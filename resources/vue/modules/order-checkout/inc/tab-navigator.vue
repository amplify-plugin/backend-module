<template>
    <div class="checkout-footer margin-top-1x">
        <div class="column">
            <a v-if="active_step.index === 0" class="btn btn-outline-secondary" @click="backToCart">
                <i class="icon-arrow-left"></i>
                <span class="hidden-xs-down"> Back To Cart </span>
            </a>

            <a v-else class="btn btn-outline-secondary" @click="navigator(active_step.index, active_step.index-1)">
                <i class="icon-arrow-left"></i>
                <span class="hidden-xs-down"> Back </span>
            </a>
        </div>
        <div class="column">
            <button v-if="active_step.index === step_length" type="button" class="btn btn-success" @click="$parent.submitOrder">
                <span class="hidden-xs-down"> {{ step_length > 2? 'Pay And Complete' : 'Complete' }} </span>
                <i class="icon-circle-check"></i>
            </button>

            <button v-else type="button" class="btn btn-primary" @click="navigator(active_step.index, active_step.index+1)">
                <span class="hidden-xs-down"> Continue </span>
                <i class="icon-arrow-right"></i>
            </button>
        </div>
    </div>

</template>

<script>
    export default {
        name: "tabNavigator",
        computed: {
            step_length() {
                return this.$parent.steps.length-1;
            },
            active_step() {
                return this.$parent.steps.find(step => step.active);
            }
        },
        methods: {
            navigator(index, navIndex) {
                this.validateStepForm(() => {
                    this.navigate(navIndex);
                }, navIndex < index);
            },
            navigate(navIndex) {
                this.$parent.steps.map(step => step.active = false);
                this.$parent.steps.find(step => step.index == navIndex).active = true;
            },
            validateStepForm(closer, bypass = false) {
                if (bypass || $("#checkout-form").valid()) {
                    closer()
                }
            },
            backToCart() {
                window.location.href = "/carts";
            }
        }
    }
</script>
