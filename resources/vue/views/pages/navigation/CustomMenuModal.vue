<template>
    <div>
        <div class="modal fade" id="custom-menu-modal" tabIndex="0" role="dialog"
             aria-labelledby="widget-attributes-modal-dialog-label"
             data-backdrop="static" data-keyboard="false"
             aria-modal="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="attribute-inline-create-dialog-label">
                            Set attributes for <strong> Custom Menu </strong>
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
                                <div class="form-group">
                                    <label for="custom-menu-title">
                                        Title
                                    </label>
                                    <input type="text" v-model="menu.title" class="form-control" id="custom-menu-title"
                                           placeholder="Enter menu title">
                                </div>

                                <div class="form-group">
                                    <label for="custom-menu-url">
                                        URL
                                    </label>
                                    <input type="text" v-model="menu.url" class="form-control" id="custom-menu-url"
                                           placeholder="Enter menu url">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                @click="modalShade = ''; resetWidgetData()"
                                aria-label="Close" id="cancelWidgetAttributesModalBtn">Cancel
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
    name : "CustomMenuModal",
    props: [],
    data() {
        return {
            modalShade       : '',
            modalBody        : 'Loading...',
            validationErrors : "",
            menu             : {
                title: '',
                url  : '',
            },
            backupMenu       : {},
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
                this.modalBody  = document.querySelector("#custom-menu-modal .modal-body").innerHTML
            }, 100);
        },

        saveData() {
            let linkCode          = `<custom-menu title="${this.menu.title}" url="${this.menu.url}"></custom-menu>`;
            this.$parent.code = linkCode;
            document.querySelector("#cancelWidgetAttributesModalBtn").click();
        },

        makeTitleCase(title) {
            if (!title) return "";

            return title.split('_')
                .map(w => w[0].toUpperCase() + w.substring(1).toLowerCase())
                .join(' ');
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
