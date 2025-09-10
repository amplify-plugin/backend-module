<template>
    <div>
        <div class="modal fade" id="edit-import-field-modal" tabIndex="0" role="dialog"
             aria-labelledby="edit-import-field-modal-dialog-label"
             data-backdrop="static" data-keyboard="false"
             aria-modal="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-moveable">
                        <h5 class="modal-title" id="edit-import-field-modal-dialog-label">
                            Edit:
                            <strong v-if="$parent.columnNames.length">{{
                                    $parent.columnNames[$parent.colIndex].column_name
                                }}</strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" @click="modalShade = ''"
                                aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Default box -->
                                <div class="card mb-0">
                                    <div class="card-body ">
                                        <div v-if="$parent.importDefinition.file">
                                            <div class="form-group ">
                                                <label>Map To</label>
                                                <select v-model="$parent.columnNames[$parent.colIndex].map_to"
                                                        name="map_to"
                                                        class="form-control">
                                                    <option value="Field">Field</option>
                                                    <option value="Attribute">Attribute</option>
                                                    <option value="Table">Table</option>
                                                    <option value="Ignore">Ignore</option>
                                                </select>
                                            </div>

                                            <div class="form-group ">
                                                <label>Field / Attribute / Table Name </label>
                                                <multiselect
                                                    @select="$parent.joinOldData($parent.columnNames[$parent.colIndex].field_or_attribute_name, $parent.columnNames[$parent.colIndex].map_to)"
                                                    @input="$parent.removeSelectedData($event, $parent.columnNames[$parent.colIndex].map_to);
                                                            $parent.onChangeFieldOrAttributeName($parent.columnNames[$parent.colIndex].field_or_attribute_name);
                                                            $parent.onChangeColumnsName($parent.columnNames[$parent.colIndex])"
                                                    :disabled="$parent.columnNames[$parent.colIndex].map_to === 'Ignore'"
                                                    v-model="$parent.columnNames[$parent.colIndex].field_or_attribute_name"
                                                    :options="$parent.columnNames[$parent.colIndex].map_to === 'Attribute' ? $parent.attributes : $parent.columnNames[$parent.colIndex].map_to === 'Table' ? $parent.tables : $parent.dbColumns"
                                                    :close-on-select="true"
                                                    :hide-selected="false"
                                                    :show-labels="false"
                                                    :placeholder="$parent.columnNames[$parent.colIndex].map_to !== 'Ignore' ? `Select ${$parent.columnNames[$parent.colIndex].map_to}`:''">
                                                </multiselect>
                                            </div>

                                            <div class="form-group ">
                                                <label>Table Field Name</label>
                                                <multiselect
                                                    :disabled="$parent.columnNames[$parent.colIndex].map_to !== 'Table'"
                                                    v-model="$parent.columnNames[$parent.colIndex].field_name"
                                                    :options="$parent.columnNames[$parent.colIndex].availableTableColumns"
                                                    :close-on-select="true"
                                                    :hide-selected="false"
                                                    :show-labels="false"
                                                    placeholder="Select Column">
                                                </multiselect>
                                            </div>

                                            <div class="form-group ">
                                                <label>Separator</label>
                                                <input
                                                    v-model="$parent.columnNames[$parent.colIndex].separator"
                                                    class="form-control">
                                            </div>


                                            <div class="form-group ">
                                                <label>Attribute Value</label>
                                                <select
                                                    :disabled="$parent.columnNames[$parent.colIndex].map_to !== 'Attribute'"
                                                    v-model="$parent.columnNames[$parent.colIndex].attribute_value"
                                                    class="form-control">
                                                    <option value="Replace">Replace</option>
                                                    <option value="Add">Add</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-moveable">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modalShade = ''"
                                aria-label="Close" id="CancelButtonImportDefinition">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div v-html="modalShade"></div>
    </div>
</template>

<script>

import _ from "lodash";
import $ from 'jquery';
import 'jquery-ui-dist/jquery-ui';

export default {
    name : "EditImportFieldModal",
    props: ['axios_url', 'locale'],
    data() {
        return {
            loadedModal: 'Loading modal...',
            modalShade : '',
            modalBody  : 'Loading...',
        }
    },
    mounted() {

    },
    components: {},
    computed  : {
        changed() {
            if (this.$parent.columnNames.length > 0)
                return this.$parent.columnNames[this.$parent.colIndex].map_to
        }
    },
    watch     : {
        changed(newValue, oldValue) {
            if (this.$parent.columnNames.length > 0)
                this.$parent.joinOldDataFromMapTo(newValue, oldValue);
        }
    },
    methods   : {
        getModal() {
            setTimeout(() => {
                $('.modal-dialog').draggable({
                    handle: ".modal-moveable"
                });
                let modalShade = document.querySelector(".modal-backdrop.fade.show");
                modalShade
                ? modalShade.remove()
                : null;
                this.modalShade = modalShade.outerHTML
                this.modalBody  = document.querySelector("#edit-import-field-modal .modal-body").innerHTML
            }, 100)
        }
    }
}
</script>

<style scoped>
@media (min-width: 1200px) {
    .modal-xl {
        max-width: 1415px !important;
    }
}
</style>
