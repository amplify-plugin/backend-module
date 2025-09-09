<template>
    <div>
        <div class="modal fade" id="showSampleModal" tabindex="0" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true"
             data-backdrop="static" data-keyboard="false"
             aria-modal="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-moveable">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Sample data for - <strong>{{ $parent.dynamicModalTitle }}</strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" @click="$parent.modalShade = ''"
                                aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">
                        <div class="card mb-0">
                            <div class="card-body">
                                <ul v-if="$parent.sampleDataForSpecificColumn && $parent.sampleDataForSpecificColumn.length > 0" class="list-group">
                                    <li class="list-group-item"
                                        v-for="(data,index) in $parent.sampleDataForSpecificColumn">
                                        {{ data }}
                                    </li>
                                </ul>

                                <div v-else class="text-center">
                                    No Data found
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-moveable">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                @click="$parent.modalShade = ''"
                                aria-label="Close" id="cancelButton">Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div v-html="$parent.modalShade"></div>
    </div>
</template>

<script>
import $     from 'jquery';
import 'jquery-ui-dist/jquery-ui';
export default {
    name: "ShowSampleModal",
    mounted(){
        $('.modal-dialog').draggable({
            handle: ".modal-moveable"
        });
    }
}
</script>

<style scoped>

</style>
