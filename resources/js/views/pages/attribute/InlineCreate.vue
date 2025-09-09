<template>
    <div>
        <div class="modal fade" id="inline-create-attribute" tabIndex="0" role="dialog"
             aria-labelledby="attribute-inline-create-dialog-label"
             data-backdrop="static" data-keyboard="false"
             aria-modal="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="attribute-inline-create-dialog-label">
                            Add attribute
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
                                aria-label="Close" id="cancelButton">Cancel
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
    name : "AttributeInlineCreate",
    props: ['axios_url', 'locale'],
    data() {
        return {
            loadedModal     : 'Loading modal...',
            modalShade      : '',
            modalBody       : 'Loading...',
            attribute       : {
                name         : '',
                is_updated   : false,
                has_range    : false,
                description  : '',
                type         : '',
                unit         : '',
                use_as_filter: false,
                searchable   : false,
                tunable      : false,
            },
            attributeBackup : _.cloneDeep(this.attribute),
            allAttributes   : [],
            validationErrors: ""
        }
    },

    components: {FormFields},

    mounted() {
        //this.getModal();
    },
    methods: {
        getModal() {
            setTimeout(() => {
                let modalShade = document.querySelector(".modal-backdrop.fade.show");
                modalShade
                ? modalShade.remove()
                : null;
                this.modalShade = modalShade.outerHTML

                this.modalBody = document.querySelector("#inline-create-attribute .modal-body").innerHTML

                this.attribute = {
                    name  : '',
                    values: {}
                };
            }, 100)
        },

        getAttributes() {
            axios.post('/admin/product/fetch/attributes')
                .then(response => {
                    this.$parent.allAttributes = response.data;
                })
        },

        saveData() {
            this.$refs.formFields.validationErrors = "";

            let params = _.cloneDeep(this.attribute);
            axios.post(`${this.axios_url}?locale=${this.locale}`, params)
                .then(response => {

                    this.attribute = _.cloneDeep(this.attributeBackup);

                    new Noty({
                        type: "success",
                        text: 'Saved successfully',
                    }).show();

                    document.querySelector("#cancelButton").click();

                    this.getAttributes();
                    this.$refs.formFields.validationErrors = "";
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
