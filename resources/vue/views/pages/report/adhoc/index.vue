<template>
    <div>
        <form @submit.prevent="getPromptResponse" class="mb-3">
            <div class="mb-3">
                <textarea class="form-control" rows="3" v-model="promptText" @keyup.enter="getPromptResponse" :disabled="promptDisabled"></textarea>
                <div class="form-row">
                    <div class="col-md-4">
                        <select class="mt-1 form-control" aria-label="category" v-model="selectedCategoryId">
                            <option value="" selected>All Categories</option>
                            <option v-for="category in categoryList" :value="category.id">{{ category.title }}</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <select class="mt-1 form-control" aria-label="suggestion" v-model="selectedPrompt"
                            @change="updatePromptText">
                            <option value="" selected disabled hidden>Select one from saved queries</option>
                            <option v-for="prompt in fiteredPrompts" :value="prompt.prompt">{{ prompt.prompt }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <button v-if="promptDisabled" class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span>Loading...</span>
            </button>
            <button v-else class="btn btn-primary" type="submit">Ask</button>

            <button class="btn btn-secondary" type="reset" @click="clearHistory">Clear</button>
        </form>

        <div class="row bg-white pt-3 pb-3" v-if="promptList.length">
            <div class="col-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a v-for="(promptData, key) in reversedPromptData" class="nav-link" :class="key < 1 ? 'active' : ''"
                        :id="`v-pills-${key}-tab`" data-toggle="pill" :href="`#v-pills-${key}`" role="tab"
                        :aria-controls="`v-pills-${key}`">
                        <span data-toggle="tooltip" data-placement="top" :title="promptData.question">
                            {{ promptData.question.substring(0, 24) }}.....
                        </span>
                    </a>
                </div>
            </div>

            <div class="col-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <div v-for="(promptData, key) in reversedPromptData" class="tab-pane fade"
                        :class="key < 1 ? 'show active' : ''" :id="`v-pills-${key}`" role="tabpanel"
                        :aria-labelledby="`v-pills-${key}-tab`">
                        <component :is="promptData.type" :prompt_data="promptData" :inc_number="key" />
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="store-report-cat-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Save {{ storePrompt.type }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" v-if="storePrompt.type == 'report'">
                            <label>Title</label>
                            <input class="form-control" v-model="storePrompt.title" />
                            <small class="text-danger" v-if="validationError.title">{{ validationError.title[0]
                                }}</small>
                        </div>

                        <div class="form-group" v-if="storePrompt.type == 'report'">
                            <label>Description</label>
                            <textarea class="form-control" v-model="storePrompt.description"></textarea>
                            <small class="text-danger" v-if="validationError.description">{{
                                validationError.description[0]
                            }}</small>
                        </div>

                        <div class="form-group">
                            <label>Report Category</label>
                            <select class="form-control" v-model="storePrompt.report_category_id">
                                <option value="" selected>Select Category</option>
                                <option v-for="category in categoryList" :value="category.id">{{ category.title }}
                                </option>
                            </select>
                            <small class="text-danger" v-if="validationError.report_category_id">{{
                                validationError.report_category_id[0]
                            }}</small>
                        </div>

                        <div class="form-group" v-if="storePrompt.type == 'report'">
                            <label>Default Presenter</label>
                            <select class="form-control" v-model="storePrompt.default_chart">
                                <option value="DataTable">Datatable</option>
                                <option v-if="storePrompt.prompt_data.show_chart" value="PieChart">Pie Chart</option>
                                <option v-if="storePrompt.prompt_data.show_chart" value="BarChart">Bar Chart</option>
                                <option v-if="storePrompt.prompt_data.show_chart" value="LineChart">Line Chart</option>
                            </select>
                            <small class="text-danger" v-if="validationError.default_chart">{{
                                validationError.default_chart[0]
                            }}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            @click="clearStorePrompt">Close</button>
                        <button type="button" class="btn btn-primary" @click="saveReport">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Table from './inc/Table.vue';
import FixWord from './inc/FixWord.vue';
import FixClarification from './inc/FixClarification.vue';

export default {
    name: "Adhoc-Report",
    props: ['api_endpoint', 'fixed_prompts', 'prompt', 'categories', 'saved_report'],
    components: { Table, FixWord, FixClarification },
    data() {
        return {
            categoryList: JSON.parse(this.categories),
            fixedPrompts: JSON.parse(this.fixed_prompts),
            promptDisabled: false,
            selectedPrompt: '',
            promptText: "",
            selectedCategoryId: "",
            promptList: [],
            storePrompt: {
                title: null,
                description: null,
                type: null,
                report_category_id: "",
                default_chart: "DataTable",
                prompt_data: {}
            },
            validationError: {}
        }
    },
    computed: {
        reversedPromptData() {
            return this.promptList.toReversed();
        },
        fiteredPrompts() {
            return this.selectedCategoryId ? this.fixedPrompts.filter((prompt) => prompt.report_category_id == this.selectedCategoryId) : this.fixedPrompts;
        }
    },
    created() {
        if (this.saved_report) {
            const savedReport = JSON.parse(this.saved_report);

            this.promptList.push({
                ...savedReport.report,
                chartType: savedReport.report_type
            });
        }

        if (this.prompt) {
            this.promptText = this.prompt;
            this.getPromptResponse();
        }
    },
    methods: {
        updatePromptText() {
            this.promptText = this.selectedPrompt;
            this.selectedPrompt = '';
            this.getPromptResponse();
        },
        getPromptResponse(call_from = 'form') {
            if (this.promptText) {
                this.copyToClipboard(this.promptText);
                this.promptDisabled = true;
                axios.get(this.api_endpoint + "?query=" + this.promptText, {
                    query: this.promptText
                })
                    .then(res => {
                        this.promptDisabled = false;
                        this.promptText = "";
                        this.promptList.push({
                            ...res.data,
                            chartType: null,
                            isUploadedQuery: call_from == 'form',
                            isUploadedReport: false,
                        });
                    })
                    .catch(err => {
                        if(err.response.status == 401) {
                            window.location.href = 'login';
                        }
                        this.promptDisabled = false;
                        new Noty({
                            type: "error",
                            text: "Something went wrong! Please try again.",
                        }).show()
                    });
            }
        },
        copyToClipboard(text) {
            const el = document.createElement('textarea');
            el.value = text.trim();
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        },
        saveReport() {
            this.validationError = {};
            axios.post('/admin/dynamic-report/store', this.storePrompt)
                .then(res => {
                    this.storePrompt.type == 'query' ?
                        this.storePrompt.prompt_data.isUploadedQuery = true
                        : this.storePrompt.prompt_data.isUploadedReport = true;

                    $('#store-report-cat-modal').modal('hide');
                    this.clearStorePrompt();
                    new Noty({
                        type: "success",
                        text: res.data.message,
                    }).show()
                })
                .catch(err => {
                    if (err.response.status == 422) {
                        this.validationError = err.response.data.errors;
                    }

                    console.log(err);
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show()
                });
        },
        clearStorePrompt() {
            this.storePrompt = {
                title: null,
                description: null,
                type: null,
                report_category_id: "",
                default_chart: "DataTable",
                prompt_data: {}
            };
        },
        clearHistory() {
            this.promptList = [];
        }
    }
}
</script>

<style>
table.table {
    width: 100% !important;
}

.dt-buttons {
    display: block !important;
}

div.dt-container div.row:last-child>div {
    display: flex;
    justify-content: space-between;
    width: 100%;
    align-items: baseline;
}

div.dt-container div.dt-length select {
    width: 3.5rem;
}

.icon-btn {
    width: 50px;
}
</style>
