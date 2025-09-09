<template>
    <div class="w-100 mt-3 mb-3">
        <p class="bg-light mb-4 py-3 rounded text-center w-100">
            {{ message }}
        </p>
    </div>
</template>

<script>
export default {
    name : "NoItemFound",
    props: {
        message: {
            default: "No Product Found",
        }
    }
}
</script>

<style scoped>

</style>
