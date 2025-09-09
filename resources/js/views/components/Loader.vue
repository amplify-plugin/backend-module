<template>
    <div class="py-5 d-block">
        <div class="text-center">
            <i class="spinner-border"
               :class="spinnerColor"
               role="status"
               aria-hidden="true">
            </i>
            <strong v-if="showLoadingText">loading...</strong>
        </div>
    </div>
</template>

<script>
export default {
    name : "Loader",
    props: {
        showLoadingText: {
            default: false
        },
        spinnerColor   : {
            default: 'text-primary'
        },
    }
}
</script>

<style scoped>

</style>
