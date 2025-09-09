<template>
    <div role="tabpanel" class="tab-pane active"
         id="tab_attributes">

        <div class="row">
            <!-- load the view from type and view_namespace attribute if set -->

            <!-- hidden input -->
            <div class="hidden">
                <input type="hidden" name="attributes" value="" class="form-control">
            </div>
            <div class="col-12 d-none">
                <div class="mb-2 text-right">
                    <div class="btn-group">
                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                class="btn btn-sm btn-primary dropdown-toggle">
                            Language: English <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" style="">
                            <a href="http://127.0.0.1:8000/admin/product-classification/6/edit?locale=en"
                               class="dropdown-item">
                                English
                            </a>
                            <a href="http://127.0.0.1:8000/admin/product-classification/6/edit?locale=fr"
                               class="dropdown-item">
                                French
                            </a>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="btn-group border-light rounded d-flex">
                    <span class="btn btn-link text-decoration-none bg-light cursor-pointer"
                          :class="{'active' : attributeType === 'required'}"
                          @click="attributeType='required'">Required
                    </span>
                    <span class="btn btn-link text-decoration-none bg-light cursor-pointer"
                          :class="{'active' : attributeType === 'optional'}"
                          @click="attributeType='optional'">Optional
                    </span>
                </div>

                <component :is="attributeType"></component>

            </div>

        </div>
    </div>
</template>

<script>
import Required from "./Required";
import Optional from "./Optional";

export default {
    name: "Attributes",

    components: {
        Required, Optional
    },

    data() {
        return {
            attributeType: 'required',
        }
    },

    mounted() {
        this.$parent.checkIfProductClassification();
    }
}
</script>

<style scoped>
.btn.active {
    /*text-decoration: underline;*/
    font-weight: bold;
}

.cursor-pointer {
    cursor: pointer;
}
</style>
