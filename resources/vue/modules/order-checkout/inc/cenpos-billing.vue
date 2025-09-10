<template>
    <section class="checkout checkout-step" :class="[`checkout-${stepId}`, { active: isActive }]" :data-parent="`#${stepId}`">
        <h4><i class="icon-paper"></i>
            Payment Method
            <a href="#" class="text-sm" data-toggle="modal" data-target="#add-card" onclick="setPositionOffCanvas(false)">Add Card</a>
        </h4>

        <!-- Cards -->
        <div class="row">
            <div
                v-for="(card, key) in card_list" :key="key"
                class="credit-card selectable"
                :class="[
                    card.CardType.toLowerCase(),
                    card.TokenID === $parent.checkout_payload.credit_card_token? '' : 'deactive'
                ]"
                @click="setCardActive(card.TokenID)"
            >
                <div class="credit-card-last4">{{ card.LastFourOfCard }}</div>
                <h4 class="credit-card-name">{{ card.NameOnCard }}</h4>
                <div class="credit-card-expiry">{{ card.CardexpirationDate }}</div>
            </div>
            <a class="credit-card bg-light text-center" href="#" data-toggle="modal" data-target="#add-card" onclick="setPositionOffCanvas(false)">
                <h4 class="credit-card-name mb-2 text-dark">Add a Credit Card</h4>
                <img src="/images/icons/circle.png" alt="">
            </a>

        </div>

        <CreateCardModal />
    </section>
</template>

<script>
    import './card-list.css'
    import CreateCardModal from "./create-card-modal.vue";

    export default {
        name: "Cenpos-Billing",
        props: ['isActive', 'stepId'],
        components: { CreateCardModal },
        data() {
            return {
                credit_card: {
                    name: "",
                    number: "",
                    expiry: "",
                    cvc: "",
                },
                card_list: [],
            }
        },
        computed: {
            states() {
                if (this.$parent.checkout_payload.billing_country) {
                    return this.$parent.states.filter(item => item.country_id == this.$parent.checkout_payload.billing_country.id)
                }
                return [];
            }
        },
        mounted() {
            this.setupCard();
            this.getCardList();
        },
        updated() {
            this.setupCard();
        },
        methods: {
            setCardActive(token) {
                this.$parent.checkout_payload.credit_card_token = token;
            },
            setupCard() {
                let $creditCard = $('.interactive-credit-card');
                if ($creditCard.length) {
                    $creditCard.card({
                        form: '.interactive-credit-card',
                        container: '.card-wrapper'
                    });
                }
            },
            clearCardInfo() {
                this.credit_card.name   = "";
                this.credit_card.number = "";
                this.credit_card.expiry = "";
                this.credit_card.cvc    = "";
            },
            async getCardList() {
                const res = await axios.post('/cenpos/v2/get-cards', {
                    customer_code: this.$parent.customerData.CustomerNumber,
                    // customer_email: this.$parent.customerData.CustomerEmail
                    customer_email: this.$parent.checkout_payload.customer_email  //Robin's instruction is to pass customer filled email here
                });

                this.card_list = res.data.card_list;

            }
        }
    }
</script>
