<template>
    <div class="row">
        <div :class="class_name">
            <!-- Default box -->
            <form method="post" @submit.prevent="" :action="backUrl">
                <div class="card">
                    <div class="card-body">
                        <FormFields ref="formFields"
                        ></FormFields>
                    </div>
                </div>

                <div id="saveActions" class="form-group">
                    <input type="hidden" name="save_action" value="save_and_back" v-model="actionType">
                    <div class="btn-group" role="group">

                        <button type="button" class="btn btn-success"
                                @click="saveData(saveAction.active.value)">
                            <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span>{{ saveAction.active.label }}</span>
                        </button>

                        <div class="btn-group" role="group">
                            <button id="bpSaveButtonsGroup" type="button" class="btn btn-success dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="caret"></span><span class="sr-only">▼</span></button>
                            <div class="dropdown-menu" aria-labelledby="bpSaveButtonsGroup">

                                <template v-for="(option, k, index) in saveAction.options">
                                    <button class="dropdown-item"
                                            type="button"
                                            :key="'actionType-'+index"
                                            @click="saveData(k)">
                                        {{ option }}
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                    <a :href="backUrl" class="btn btn-default"><span
                        class="la la-ban"></span> &nbsp;Cancel</a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import FormFields from "./FormFields";

export default {
    name: "HeroSliderCreate",
    components: {FormFields},
    props: [
        'url', 'axios_url', 'query_string', 'class_name',
        'method', 'hero_slider_data', 'save_action',
        'template_colors', 'banner_zones'
    ],

    data() {
        return {
            backUrl: '/admin/banner',
            slider: {
                alignment: 'left',
                image: '',
                banner_zone_id: '',
                background_image: '',
                slider_ratio: 6,
                background_type: 'image',
                foreground_type: 'image',
                text_alignment: 'left',
                image_alignment: 'center',
                enabled: true
            },
            actionType: 'save_and_back',
            saveAction: JSON.parse(this.save_action),
            validationErrors: {},
            templateColors: {},
            bannerZoneArray: JSON.parse(this.banner_zones)
        }
    },
    created() {
        if (this.method === 'put') {
            this.slider = JSON.parse(this.hero_slider_data)
        }
        // this.bannerZoneArray[''] = 'Select an banner zone';
        this.templateColors = JSON.parse(this.template_colors)
    },

    methods: {
        saveData(actionType) {
            this.validationErrors = {};
            let params = this.slider;

            params._save_action = actionType;

            axios[this.method](`${this.axios_url}`, params)
                .then(response => {
                    new Noty({
                        type: "success",
                        text: "Saved Successfully",
                    }).show();

                    window.location.href = "/" + response.data.redirect_url;
                })
                .catch((err) => {
                    new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();

                    this.validationErrors = err.response.data.errors;
                });
        },
        cancel() {
            window.location = this.backUrl;
        },
    },
}
</script>
