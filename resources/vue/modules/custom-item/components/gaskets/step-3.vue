<template>
    <div
        :class="orderStep === 3 ? 'order-step-block' : 'order-step-d-none'"
        v-if="retainerStatus && profileProducts.length > 0"
        class="row mb-4 mb-sm-5"
        id="gaskets_three"
    >
        <div class="col-12">
            <div class="title mb-3 d-flex align-items-center gap-2">
                <i
                    :class="[$parent.completedSection.includes(3) ? 'text-success' : 'text-black-50']"
                    class="icon-circle-check"
                ></i>
                <h5
                    class="mb-0 text-uppercase fw-600"
                    :class="[$parent.completedSection.includes(3) ? 'text-success' : 'text-danger']"
                >
                    Step 3
                </h5>
            </div>
            <p class="fw-600 text-dark mb-4 text-capitalize">Select Your Gasket Profile Below</p>
        </div>
        <div v-for="(data, index) in profileProducts" class="col-md-3 mb-4" :key="index">
            <div
                @click="
                    setProfile(data),getPrice(data);
                    $parent.gasketProfileStatus = data.product_code;
                "
                :class="data.product_code === gasketProfileStatus && 'active'"
                class="gasket-type position-relative p-4 d-flex flex-column justify-content-center"
                type="button"
            >
                <img class="w-100 mw-200 align-self-center" :src="data.thumbnail" :alt="data.product_code" />
                <h6 class="fw-600">ORDER#: {{ data.product_code }}</h6>
                <h6 class="fw-600"v-if="data?.attributes.length > 0" v-for="(attribute) in data?.attributes">{{ attribute.name }}: {{getAttibuteValue(attribute.value)}} </h6>
            </div>
        </div>
        <!--FINAL-->
        <div v-if="gasketProfileStatus" class="col-12">
            <div class="row">
                <div class="col-12">
                    <h6 class="text-danger">You Have Chosen This Profile:</h6>
                </div>
                <div class="col-md-4 mb-4">
                    <div
                        :class="gasketProfileStatus && 'active'"
                        class="gasket-type remove-selected-text position-relative p-4 d-flex flex-column justify-content-center align-items-center"
                        type="button"
                    >
                        <img
                            class="w-100 mw-200"
                            :src="singleProfileProducts.thumbnail"
                            :alt="singleProfileProducts.product_code"
                        />
                        <h6 class="fw-600">{{ singleProfileProducts.product_code }}</h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="border rounded-md p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fw-500 text-uppercase">LIST PRICE PER FOOT:</div>
                            <input
                                :disabled="true"
                                v-model="productPrice"
                                type="text"
                                placeholder="0"
                                class="form-control w-90"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
export default {
    name: 'step-3',
    props: [
        'retainerStatus',
        'gasketProfileStatus',
        'orderStep',
        'stepThreeProductGasketProfileFinal',
        'stepThreeProductGasketProfile',
        'stepThreeProductGasket',
    ],
    methods: {
        ...mapActions('gasket', ['setProfile','getPrice']),
        getAttibuteValue(data){
            let jsonData = JSON.parse(data);
            return Object.values(jsonData)[0];
        }
    },
    computed: {
        ...mapState('gasket', ['profileProducts', 'singleProfileProducts', 'productPrice']),
    },
};
</script>
