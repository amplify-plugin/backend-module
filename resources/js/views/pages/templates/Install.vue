<template>
    <form method="post" @submit.prevent="" :action="backUrl">
        <div class="card" v-if="!templateInfo">
            <div class="card-body">
                <div id="container" class="rounded">
                    <button type="button" class="btn btn-link" id="browse-button">
                        {{ filename }}
                    </button>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar"
                         style="width: 0;" id="progress-bar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-block mt-3" @click="startUpload" ref="upload">Upload
                </button>
            </div>
        </div>
        <div class="card mt-2" v-if="templateInfo">
            <div class="card-header">
                <h4 class="card-title">Template Detail</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>Template Name</td>
                            <td>{{ templateInfo.name }}</td>
                        </tr>
                        <tr>
                            <td>Author</td>
                            <td>{{ templateInfo.author }}</td>
                        </tr>
                        <tr>
                            <td>Preview</td>
                            <td class="text-center">
                                <img :src="templateInfo.template_banner" class="img-fluid"/>
                            </td>
                        </tr>
                    </table>
                </div>
                <button type="button" class="btn btn-primary btn-block" @click="installTemplate" ref="install">
                    Install
                </button>
            </div>
        </div>
    </form>
</template>
<script>
import _ from "lodash";
import saveActionMixin from "../../../mixin/saveAction.js";

function updateProgress(value) {
    let progressBar = document.getElementById('progress-bar');
    progressBar.innerText = value + '%';
    progressBar.style.width = value + '%';
    progressBar.setAttribute('aria-valuenow', value);
}

function updateBrowseLabel(text) {
    document.getElementById("browse-button").innerText = text;
}

export default {
    name: "TemplateInstall",
    mixins: [saveActionMixin],
    data() {
        return {
            backUrl: '/admin/template',
            chunkFileUploadUrl: '/admin/template/chunk-upload',
            getInstallationInfoUrl: '/admin/template/installation-info',
            installTemplateUrl: '/admin/template/install-template',
            templateInfo: null,
            uploader: {},
            filename: 'Browse files',
            validationErrors: {},
        }
    },
    mounted() {
        this.setupPlupload();
    },
    methods: {
        setupPlupload() {
            const self = this;
            this.uploader = new plupload.Uploader({
                url: self.chunkFileUploadUrl,
                chunk_size: '1mb',
                runtimes: 'html5',
                browse_button: "browse-button",
                container: "container",
                filters: {
                    max_file_size: '200mb',
                    mime_types: [
                        {title: "Zip files", extensions: "zip"}
                    ]
                },
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                init: {
                    FilesAdded: function (up, files) {
                        up.files.splice(0, up.files.length - 1);
                        updateBrowseLabel(files[0].name);
                    },
                    FileUploaded: function (up, files, res) {
                        const data = JSON.parse(res.response);
                        new Noty({
                            text: data.result.message,
                            type: "success"
                        }).show();

                        self.setUpInstallationProcess();
                    },
                    UploadProgress: function (up, files) {
                        updateProgress(files.percent);
                    },
                    Error: function (up, args) {
                        updateProgress(0);
                        updateBrowseLabel('Browse files');
                        new Noty({
                            text: "Something went wrong.",
                            type: "danger"
                        }).show();
                    }
                }
            });
            this.uploader.init();
        },
        startUpload() {
            if (this.uploader.files.length) {
                this.$refs.upload.disabled = true;
                this.$refs.upload.textContent = "Loading...";

                this.templateInfo = null;
                this.uploader.start();
            } else {
                new Noty({
                    text: "Please select a template.",
                    type: "danger"
                }).show();
            }
        },
        setUpInstallationProcess() {
            axios.get(this.getInstallationInfoUrl)
                .then(res => {
                    this.templateInfo = res.data;
                })
                .catch(err => {
                    updateProgress(0);
                    updateBrowseLabel('Browse files');
                    new Noty({
                        text: err.response.data.message,
                        type: "danger"
                    }).show();
                });

            this.$refs.upload.disabled = false;
            this.$refs.upload.textContent = "Upload";
        },
        async installTemplate() {
            this.$refs.install.disabled = true;
            this.$refs.install.textContent = "Installing...";

            await axios.post(this.installTemplateUrl)
                .then(res => {
                    new Noty({
                        text: res.data.message,
                        type: "success"
                    }).show();
                })
                .catch(err => {
                    new Noty({
                        text: err.response.data.message,
                        type: "danger"
                    }).show();
                });

            this.$refs.install.disabled = false;
            this.$refs.install.textContent = "Install";
        }
    },
    watch: {
        "this.uploader": function (value) {
            if (value.length == 0) {
                this.filename = 'Browse files';
            }
            console.log(value);
        }
    }
}
</script>

<style scoped lang="scss">
.progress {
    border-radius: 0.5rem;
    border-top-left-radius: 0 !important;
    border-top-right-radius: 0 !important;
    border: 3px dashed rgba(0, 40, 100, .12) !important;
    border-top: 0 !important;

    &:hover {
        background-color: rgba(0, 40, 100, .12);
    }
}

#container {
    height: 250px;
    border: 3px dashed rgba(0, 40, 100, .12) !important;
    border-bottom: 0 !important;

    &:hover {
        background-color: rgba(0, 40, 100, .12);
    }
}

#browse-button {
    display: block;
    margin: auto auto;
    top: 40%;
    font-size: 150%;
    text-decoration: none;

    &:focus {
        box-shadow: none;
        border: 0;
    }
}

</style>
