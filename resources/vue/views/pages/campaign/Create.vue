<template>
    <div class="row">
        <div class="col-md-12 bold-labels">
            <div class="mb-3" v-if="Object.keys(validationErrors).length > 0">
                <div class="alert alert-danger pb-0">
                    <ul class="list-unstyled">
                        <li v-for="(error, index) in validationErrors" :key="index">
                            <i class="la la-info-circle"></i>
                            {{ error[0] ?? '' }}
                        </li>
                    </ul>
                </div>
            </div>
            <form method="post" @submit.prevent="" :action="backUrl">
                <FormFields ref="formFields"></FormFields>
                <div id="saveActions" class="form-group" v-if="method !== 'get'">
                    <input type="hidden" name="save_action" v-model="actionType"/>

                    <button @click="actionType = 'save_and_back'; saveData();" type="button" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span>
                        &nbsp;
                        <span data-value="save_and_edit"> Save and back</span>
                    </button>
                    <button @click="saveAndAction('cancel')" type="button" class="btn btn-default">
                        <span class="la la-ban"></span> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import FormFields from "./FormFields";
import ProductModule from "./ProductModule.vue";

export default {
    name: "CampaignCreate",
    components: {ProductModule, FormFields},
    props: ['entry', 'page_list', 'banner_zone_list', 'discount_types', 'method', 'store_or_update_url', 'category_url', 'class_name'],
    data() {
        return {
            campaign: {
                name: "",
                slug: "",
                page_id: "",
                banner_zone_id: "",
                description: "",
                code: "",
                status: false,
                login_required: false,
                start_date: "",
                end_date: "",
                campaign_products: [],
            },
            validationErrors: {},
            backUrl: "/admin/campaign",
            newUrl: "/admin/campaign/create",
            axiosUrl: this.store_or_update_url,
            actionType: "save_and_back",
            campaignDetails: JSON.parse(this.entry),
            pages: JSON.parse(this.page_list),
            banner_zones: JSON.parse(this.banner_zone_list),
            discountTypes: JSON.parse(this.discount_types),
        };
    },
    created() {
    },
    mounted() {
        axios.get(this.category_url)
            .then(response => {
                this.categoriesForSubCategory = response.data;
            });

        if (this.method !== "post") {
            this.initEdit();
            this.getProduct();
        }

    },
    methods: {
        initEdit() {
            this.campaign = {
                name: this.campaignDetails.name,
                slug: this.campaignDetails.slug,
                page_id: this.campaignDetails.page_id,
                banner_zone_id: this.campaignDetails.banner_zone_id,
                code: this.campaignDetails.code,
                description: this.campaignDetails.description,
                start_date: this.campaignDetails.start_date,
                end_date: this.campaignDetails.end_date,
                status: this.campaignDetails.status,
                login_required: this.campaignDetails.login_required,
                campaign_products: this.campaignDetails.products.map(function (product) {
                    return {
                        product_id: product.id,
                        discount_type: product.pivot.discount_type,
                        discount: product.pivot.discount,
                        n1: product.pivot.n1,
                        n2: product.pivot.n2,
                    };
                })
            };
        },

        getProduct() {
            for (let product of this.campaign.campaign_products) {
                this.$refs.formFields.$refs.productModule.getEasyAskProducts(product.product_id, false);
            }
        },

        saveData() {
            this.validationErrors = {};
            axios[this.method](`${this.axiosUrl}`, this.campaign)
                .then((response) => {
                    window.location.href = this.backUrl;
                })
                .catch((err) => {
                    this.validationErrors = err.response.data.errors;

                    if (err.response.status != 422) {
                        new Noty({
                            type: "error",
                            text: err.response.data.message,
                        }).show();
                    }

                });
        },

        saveAndAction(argument) {
            if (argument === "cancel") {
                window.location = "/admin/campaign";
            }
        },
    },
};
</script>

<style scoped></style>
