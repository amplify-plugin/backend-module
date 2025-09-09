<template>
    <div>
        <div class="modal fade" id="dropdown-menu-modal" tabIndex="0" role="dialog"
             aria-labelledby="widget-attributes-modal-dialog-label"
             data-backdrop="static" data-keyboard="false"
             aria-modal="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="attribute-inline-create-dialog-label">
                            Set attributes for <strong> Dropdown Menu </strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal"
                                @click="modalShade = ''; resetWidgetData()"
                                aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body bg-light">

                        <!-- Default box -->
                        <div class="card" style="margin-bottom: 0rem!important;">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="custom-menu-title">
                                            Title
                                        </label>
                                        <input type="text" v-model="menu.title" class="form-control"
                                               id="custom-menu-title"
                                               placeholder="Enter menu title">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="custom-menu-url">
                                            URL
                                        </label>
                                        <input type="text" v-model="menu.url" class="form-control" id="custom-menu-url"
                                               placeholder="Enter menu url">
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            Dropdown Menu Items
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="input-group mb-3"
                                                     v-for="(dropdownItem, dropdownIndex) in menu.children"
                                                     :key="'dropdown-item' + dropdownIndex">
                                                    <input type="text" class="form-control" v-model="dropdownItem.title"
                                                           placeholder="Enter dropdown menu title">

                                                    <input type="text" class="form-control" v-model="dropdownItem.url"
                                                           placeholder="Enter dropdown menu url">

                                                    <div class="input-group-append">
                                                        <button class="btn btn-danger" type="button"
                                                                @click.prevent="removeDropdownItem(dropdownIndex)"
                                                                v-if="menu.children.length > 1">
                                                            <i class="las la-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div v-if="!showPageSelect">
                                                    <button class="btn btn-primary" type="button"
                                                            @click.prevent="addDropdownItem">
                                                        <i class="las la-plus"></i>
                                                        Add Custom Item
                                                    </button>

                                                    <button class="btn btn-primary" type="button"
                                                            @click.prevent="handleAddPage(true)">
                                                        <i class="las la-plus"></i>
                                                        Add Page
                                                    </button>
                                                </div>

                                                <div v-else>
                                                    <multiselect
                                                        v-model="selectedPage"
                                                        :options="$parent.pageLists"
                                                        placeholder="Select a page"
                                                        @input="addPageToDropdownItem"
                                                        label="name"
                                                        track-by="name">
                                                    </multiselect>

                                                    <button class="btn btn-primary mt-2" type="button"
                                                            @click.prevent="handleAddPage(false)">
                                                        <i class="las la-undo"></i>
                                                        Back
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                @click="modalShade = ''; resetWidgetData()"
                                aria-label="Close" id="cancelDropdownMenuModalBtn">Cancel
                        </button>

                        <button type="button" class="btn btn-primary" @click="saveData()"
                                id="saveButton">Generate Menu
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
    name : "DropdownMenuModal",
    props: [],
    data() {
        return {
            modalShade      : '',
            modalBody       : 'Loading...',
            validationErrors: "",
            menu            : {
                title   : '',
                url     : '',
                children: [
                    {
                        'title': '',
                        'url'  : '',
                    }
                ],
            },
            backupMenu      : {},
            selectedPage    : '',
            showPageSelect  : false,
        }
    },

    components: {},

    mounted() {
        this.backupMenu = _.cloneDeep(this.menu);
    },
    methods: {
        getModal() {
            setTimeout(() => {
                let modalShade = document.querySelector(".modal-backdrop.fade.show");
                modalShade ? modalShade.remove() : null;
                this.modalShade = modalShade.outerHTML
                this.modalBody  = document.querySelector("#dropdown-menu-modal .modal-body").innerHTML
            }, 100);

            this.showPageSelect = false;
            this.selectedPage   = '';
        },

        saveData() {
            let childrenMenus = ``;
            this.menu.children.forEach((menu, index) => {
                childrenMenus += `<dropdown-menu-item title="${menu.title}" url="${menu.url}"></dropdown-menu-item>`;
            });
            let linkCode      = `<dropdown-menu dropdown="true" title="${this.menu.title}" url="${this.menu.url}">${childrenMenus}</dropdown-menu>`;
            this.$parent.code = linkCode;

            new Noty({
                type: "success",
                text: 'Menu generated successfully',
            }).show();
            document.querySelector("#cancelDropdownMenuModalBtn").click();
        },

        addDropdownItem() {
            this.menu.children.push({
                'title': '',
                'url'  : '',
            });
        },

        handleAddPage(showPageSelect) {
            this.showPageSelect = showPageSelect;
            this.selectedPage   = '';
        },

        addPageToDropdownItem() {
            if(this.checkIfPageExists(this.selectedPage)) {
                new Noty({
                    type: "error",
                    text: 'Page already added',
                }).show();
                return;
            }

            this.showPageSelect = false;
            this.menu.children.push({
                'title': this.selectedPage.title,
                'url'  : this.selectedPage.url,
            });
        },

        checkIfPageExists(page) {
            let exists = false;
            this.menu.children.forEach((menu, index) => {
                if (menu.url === page.url) {
                    exists = true;
                }
            });
            return exists;
        },

        removeDropdownItem(index) {
            this.menu.children.splice(index, 1);
        },

        resetWidgetData() {
            this.menu                      = _.cloneDeep(this.backupMenu);
            this.$parent.activeWidgetIndex = undefined;
        },
    }
}
</script>

<style scoped>
h5 {
    text-align: center;
    position: relative;
    background-color: #fff;
}

h5 .border {
    border-bottom: 3px solid #999;
    position: absolute;
    width: 100%;
    left: 0;
    top: 50%;
    margin-top: -1px;
    z-index: 1;
}

h5 .text {
    background-color: #fff;
    position: relative;
    z-index: 2;
    padding: 10px;
    display: inline-block;
}
</style>
