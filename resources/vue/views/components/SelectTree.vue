<template>
    <div>
        tree001
        <treeselect
            :class="{'is-invalid': $parent.validationErrors.product_classifications || $parent.validationErrors.product_classification_id}"
            :multiple="false"
            placeholder="Select a classification"
            :options="options"
            v-model="id"/>
    </div>
</template>

<script>
import Treeselect from "@riophae/vue-treeselect";

export default {
    name      : "SelectTree",
    props     : ['options'],
    components: {Treeselect},
    mounted() {
        console.log('mounted tree001')
    },
}
</script>

<style scoped>

</style>
