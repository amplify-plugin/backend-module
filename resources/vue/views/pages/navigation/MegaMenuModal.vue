<template>
    <div>
        <div class="modal fade" id="mega-menu-modal" tabIndex="0" role="dialog"
            aria-labelledby="widget-attributes-modal-dialog-label" data-backdrop="static" data-keyboard="false"
            aria-modal="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="attribute-inline-create-dialog-label">
                            Set attributes for <strong> Mega Menu </strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" @click="modalShade = '';resetWidgetData();" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body bg-light">
                        <!-- Default box -->
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-info btn-sm mb-2">Section +</button>

                                <div class="card" style="margin-bottom: 0rem !important">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="section-title">Section Title</label>
                                            <input type="text" class="form-control" placeholder="Write section title" />
                                        </div>
                                        <button class="btn btn-info btn-sm mt-4">URL +</button>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" placeholder="Enter url title" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="url">URL (Slug)</label>
                                                <input type="text" class="form-control" placeholder="Enter url slug" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-info btn-sm mb-2">Section +</button>

                                <div class="card" style="margin-bottom: 0rem !important">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="section-title">Section Title</label>
                                            <input type="text" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label for="sub-title">Sub Title</label>
                                            <input type="text" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label for="btn-name">Button Name</label>
                                            <input type="text" class="form-control" placeholder="Button name" />
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Banner Image</label>
                                            <input type="file" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modalShade = '';resetWidgetData();" aria-label="Close" id="cancelMegaMenuModalBtn">
                            Cancel
                        </button>

                        <button type="button" class="btn btn-primary" @click="saveData()" id="saveButton">
                            Generate Menu
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div v-html="modalShade"></div>
    </div>
</template>

<script>
export default {
    name: "MegaMenuModal",
    props: [],
    data() {
        return {
            modalShade: "",
            modalBody: "Loading...",
            validationErrors: "",
            backupMenu: {},
            selectedPage: "",
            showPageSelect: false,
        };
    },
    mounted() {
        this.backupMenu = _.cloneDeep(this.Menu);
    },
    methods: {
        getModal() {
            setTimeout(() => {
                let modalShade = document.querySelector(".modal-backdrop.fade.show");
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade.outerHTML;
                this.modalBody = document.querySelector(
                    "#mega-menu-modal .modal-body"
                ).innerHTML;
            }, 100);

            this.showPageSelect = false;
            this.selectedPage = "";
        },
        saveData() { },
    },
};
</script>
