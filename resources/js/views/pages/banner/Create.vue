<template>
        <div class="row">
            <div class="col-lg-8">
                <!-- Default box -->
                <form method="post" @submit.prevent="" :action="backUrl">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <div class="card">
                        <div class="card-body">
                            <FormFields ref="formFields"></FormFields>
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
import _ from "lodash";
import FormFields from "./FormFields";
export default {
    name: "BannerCreate",
    components: { FormFields },

    props: [
        "url",
        "method",
        "axios_url",
        "query_string",
        "banner_details",
        'save_action'
    ],
    data() {
        return {
            banner: new Form({
                name: "",
                desc: "",
                code: "",
                type: "html",
                content: "",
                image_path: "",
                image_text: "",
                image_text_link: "",
                video_link: "",
            }),
            backUrl: "/admin/banner",
            newUrl: "/admin/banner/create",
            actionType: "save_and_back",
            saveAction      : JSON.parse(this.save_action),
            validationErrors: {},
            bannerDetails: {},
            bannerID: null
        };
    },

    created() {
        this.bannerID = JSON.parse(this.banner_details).id;
        this.bannerDetails = JSON.parse(this.banner_details);

        if (this.method !== "post") {
            this.initEdit();
        }
    },

    methods: {
        initEdit() {

            this.banner = new Form({
                id: this.bannerDetails.id,
                name: this.bannerDetails.name,
                desc: this.bannerDetails.desc,
                code: this.bannerDetails.code,
                type: this.bannerDetails.type,
                content: this.bannerDetails.content,
                image_path: this.bannerDetails.image_path,
                image_text: this.bannerDetails.image_text,
                image_text_link: this.bannerDetails.image_text_link,
                video_link: this.bannerDetails.video_link,
            });
        },

        saveAndAction(argument) {
            if (argument === "cancel") {
                window.location = "/admin/banner/" + this.bannerDetails.id;
            }
        },

        saveData(actionType) {
            this.validationErrors = {};
            this.banner._save_action = actionType;
            let params             = _.cloneDeep(this.banner);

            axios[this.method](`${this.axios_url}`, params)
                .then((response) => {
                    window.location.href = "/"+response.data.redirect_url;
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;
                    if(err.response.status!=422){
                        new Noty({
                        type: "error",
                        text: err.response.data.message,
                    }).show();
                    }

                });
        },
    },
};
</script>

<style scoped>
.height-100 {
    height: 100px;
}

.height-150 {
    height: 150px;
}

.fixed-height {
    height: 350px;
    overflow: auto;
}

.btn-clipboard {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    z-index: 10;
    display: block;
    padding: 0.25rem 0.5rem;
    font-size: 75%;
    color: #ffffff;
    background-color: transparent;
    border: 0;
    border-radius: 0.25rem;
}

.btn-clipboard:hover {
    color: #fff;
    background-color: #ffa000;
}
</style>
