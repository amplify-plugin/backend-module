<template>
    <div class="row p-3 mb-5">
        <div class="form-group row">
            <label class="col-form-label">Customer Name</label>
            <div class="col">
                <input type="text" readonly class="form-control-plaintext" value="Xyz retail inc.">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-form-label">User</label>
            <div class="col">
                <input type="text" readonly class="form-control-plaintext" value="Mr. Brain">
            </div>
        </div>

        <div class="col-12"></div>
        <div class="form-group row">
            <label for="cus-ref" class="col-form-label">Customer Order Reference</label>
            <div class="col">
                <input type="text" class="form-control" id="cus-ref" placeholder="Ref...">
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "CartCustomerDetails"
    }
</script>
<style>
</style>
