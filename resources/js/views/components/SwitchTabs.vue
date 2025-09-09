<template>
    <div class="d-flex justify-content-between p-3">
        <button @click="$parent.activeTab = $parent.getNextTab(false);" type="button"
                :disabled="Object.keys(this.$parent.tabs)[0] === this.$parent.activeTab"
                class="btn btn-light">
            <span class="la la-chevron-left" role="presentation" aria-hidden="true"></span>
            <span> Previous</span>
            <i class="las la-stream"></i>
        </button>
        <button @click="$parent.activeTab = $parent.getNextTab(true);" type="button"
                :disabled="Object.keys(this.$parent.tabs).reverse()[0] === this.$parent.activeTab"
                class="btn btn-light">
            <i class="las la-stream"></i>
            <span> Next</span>
            <span class="la la-chevron-right" role="presentation" aria-hidden="true"></span>
        </button>
    </div>
</template>

<script>
export default {
    name: "SwitchTabs"
}
</script>
<style scoped>

</style>
