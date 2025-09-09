<template>
    <div>
        <div class="modal fade" id="inline-create-option" tabIndex="0" role="dialog"
             aria-labelledby="option-inline-create-dialog-label"
             data-backdrop="static" data-keyboard="false"
             aria-modal="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="option-inline-create-dialog-label">
                            Add option
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" @click="modalShade = ''"
                                aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">

                        <!-- Default box -->
                        <div class="card">
                            <div class="card-body">
                                <FormFields
                                    :validationErrors="validationErrors"
                                    ref="formFields"
                                ></FormFields>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modalShade = ''"
                                aria-label="Close" id="optionCancelButton">Cancel
                        </button>
                        <button type="button" class="btn btn-primary" @click="saveData()" id="saveButton">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-html="modalShade"></div>
    </div>
</template>

<script>
import FormFields from "./FormFields";

export default {
    name : "OptionInlineCreate",
    props: ['axios_url'],
    data() {
        return {
            loadedModal        : 'Loading modal...',
            modalShade         : '',
            modalBody          : 'Loading...',
            option             : {
                option_name  : '',
                is_required  : false,
                description  : '',
                option_type  : 'text',
                value_type   : 'Yes/No',
                default_value: '',
                limit_min    : '',
                limit_max    : '',
                limit_choices: '',
            },
            defaultOption      : {},
            isOptionTypeBoolean: false,
            validationErrors   : ""
        }
    },

    components: {FormFields},

    mounted() {
        this.defaultOption = _.cloneDeep(this.option);
    },
    methods: {
        getModal() {
            setTimeout(() => {
                let modalShade = document.querySelector(".modal-backdrop.fade.show");
                modalShade
                ? modalShade.remove()
                : null;
                this.modalShade = modalShade.outerHTML

                this.modalBody = document.querySelector("#inline-create-option .modal-body").innerHTML
            }, 100)
            this.option = _.cloneDeep(this.defaultOption);
        },

        saveData() {
            this.$refs.formFields.validationErrors = "";
            let params                             = _.cloneDeep(this.option);
            params.limit_choices                   = JSON.stringify(params.limit_choices);
            axios.post(`${this.axios_url}`, params)
                .then(response => {
                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();
                    this.$refs.formFields.validationErrors = "";
                    document.querySelector("#optionCancelButton").click();
                    this.$parent.getAllOptions();
                })
                .catch((err) => {
                    this.$refs.formFields.validationErrors = err.response.data.errors;
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    console.error(err);
                });
        }
    }
}
</script>

<style scoped>

</style>
