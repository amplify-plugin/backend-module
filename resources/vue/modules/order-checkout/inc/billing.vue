<template>
    <section class="checkout checkout-step" :class="[`checkout-${stepId}`, { active: isActive }]" :data-parent="`#${stepId}`">
        <h4><i class="icon-paper"></i> Payment Method</h4>

        <div class="row d-flex justify-content-center">
            <div class="col-xs-12 col-md-8 col-lg-5">
                <p id="cenpos-error-message" style="display: none;">
                    N.B: Double clicking on the Credit card also initiate the payment.
                </p>
                <div id="CenposPlugin" style="min-height: 428px;">
                    <div class="w-100 h-100 justify-content-center align-items-center" style="padding-top: 214px;">
                        <img src="/img/loading.gif" style="margin-left: 47%;"/>
                    </div>
                </div>

                <form method="POST" action="">
                    <input type="hidden" name="cardname" value="">
                    <input type="hidden" name="cc_token" value="">
                    <input type="hidden" name="last_four" value="">
                    <input type="hidden" name="cc_cardtype" value="">
                    <input type="hidden" name="cardexpmonth" value="">
                    <input type="hidden" name="cardexpyear" value="">
                    <input type="hidden" name="cardtype" value="">

                    <button class="btn btn-primary btn-block" type="button" id="paySubmit">Add Card</button>
                </form>
            </div>
        </div>

        <div id="cenpos-failed-body" class="d-none">
            <h3 class="h3 text-center text-danger mb-4">Sorry something has gone wrong!</h3>
            <p>
                We are sorry, but we are unable to connect with the payment processing system for your credit card.
                Please contact Mountain West with the following information.
            </p>

            <div class="d-flex justify-content-center mb-5">
                <a href="/shop" class="btn btn-outline-primary">Return to Shop</a>
            </div>
        </div>

    </section>
</template>

<script>
    export default {
        name: "Billing",
        props: ['isActive', 'stepId'],
    }
</script>
