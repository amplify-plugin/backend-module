<template>
    <section class="checkout checkout-step" :class="[`checkout-${stepId}`, { active: isActive }]" :data-parent="`#${stepId}`">
        <h4><i class="icon-head"></i> Account Information</h4>
        <hr class="padding-bottom-1x">

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="customer_name">Customer Name <span class="text-danger font-weight-bold">*</span></label>
                    <input required class="form-control" type="text" id="customer_name" name="customer_name" v-model="$parent.checkout_payload.customer_name" :disabled="!$parent.isGuestUser" />
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="customer_email">E-mail Address <span class="text-danger font-weight-bold">*</span></label>
                    <input required class="form-control" type="email" id="customer_email" name="customer_email" v-model="$parent.checkout_payload.customer_email" :disabled="!$parent.isGuestUser" />
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="customer_phone">Phone Number <span class="text-danger font-weight-bold">*</span></label>
                    <input required class="form-control" type="text" id="customer_phone" name="customer_phone" v-model="$parent.checkout_payload.customer_phone" :disabled="!$parent.isGuestUser" />
                    <span class="invalid-feedback"></span>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "Customer",
        props: ['isActive', 'stepId'],
        components: {}
    }
</script>
