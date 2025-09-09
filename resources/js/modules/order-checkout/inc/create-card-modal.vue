<template>
    <div class="modal fade" id="add-card" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Card</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <p>
                                We accept following credit cards:
                                <img class="d-inline-block align-middle" src="/images/credit-cards.png" style="width: 120px;" alt="Credit Cards">
                            </p>
                            <div class="card-wrapper"></div>
                            <div class="interactive-credit-card">
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <input required minlength="15" class="form-control billing-info" type="text" name="number" placeholder="Card Number*" v-model="credit_card.number" />
                                        <span class="invalid-feedback"></span>
                                        <small v-if="validationErrors.number" class="text-danger mt-3">{{ validationErrors.number[0] }}</small>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <input required class="form-control" type="text" name="expiry" placeholder="MM/YY*" v-model="credit_card.expiry" />
                                        <span class="invalid-feedback"></span>
                                        <small v-if="validationErrors.expiry" class="text-danger mt-3">{{ validationErrors.expiry[0] }}</small>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <input required class="form-control" type="text" name="cvc" placeholder="CVC*" v-model="credit_card.cvc" />
                                        <span class="invalid-feedback"></span>
                                        <small v-if="validationErrors.cvc" class="text-danger mt-3">{{ validationErrors.cvc[0] }}</small>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <input required class="form-control billing-info" type="text" name="name" placeholder="Full Name*" v-model="credit_card.name" />
                                        <span class="invalid-feedback"></span>
                                        <small v-if="validationErrors.name" class="text-danger mt-3">{{ validationErrors.name[0] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="bill-to-address">Address <span class="text-danger font-weight-bold">*</span></label>
                                <input required class="form-control billing-info" name="billing_address" type="text" id="bill-to-address" v-model="credit_card.billing_address"/>
                                <small v-if="validationErrors.billing_address" class="text-danger mt-3">{{ validationErrors.billing_address[0] }}</small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="bill-to-zip-code">ZIP Code <span class="text-danger font-weight-bold">*</span></label>
                                <input required class="form-control billing-info" name="billing_zip_code" type="text" id="bill-to-zip-code" v-model="credit_card.zip_code"/>
                                <small v-if="validationErrors.zip_code" class="text-danger mt-3">{{ validationErrors.zip_code[0] }}</small>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" :disabled="loading" @click="addNewCard">Create</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";

    export default {
        name: "CreateCard",
        components: { Multiselect },
        data() {
            return {
                loading: false,
                validationErrors: {},
                credit_card: {
                    name: "",
                    number: "",
                    expiry: "",
                    cvc: "",
                    billing_address: "",
                    zip_code: ""
                },
            }
        },
        methods: {
            addNewCard() {
                this.getLoader();
                this.validationErrors = {};

                const payload = {
                    ...this.credit_card,
                    customer_number: this.$parent.$parent.customerData.CustomerNumber,
                    // customer_email: this.$parent.$parent.customerData.CustomerEmail
                    customer_email: this.$parent.$parent.checkout_payload.customer_email  //Robin's instruction is to pass customer filled email here
                }

                axios.post('/cenpos/v2/add-card', payload).then(async res => {
                    this.$parent.$parent.checkout_payload.credit_card_token = res.data.card_token;
                    await this.$parent.getCardList();

                    $('#add-card').modal('hide');
                    this.resetCardFields();
                    this.removeLoader('success', "Successfully created.");
                }).catch(error => {
                    this.validationErrors = error.response.data.errors ?? [];
                    this.removeLoader('error', error.response.data.message);
                });
            },
            resetCardFields() {
                this.credit_card = {
                    name: "",
                    number: "",
                    expiry: "",
                    cvc: "",
                    billing_address: "",
                    zip_code: ""
                };
            },
            getLoader() {
                getFullPageLoader();
                this.loading = true;
            },
            removeLoader(type, message) {
                this.loading = false;
                ShowNotification(type, type, message);
                removeFullPageLoader();
            }
        }
    }
</script>
