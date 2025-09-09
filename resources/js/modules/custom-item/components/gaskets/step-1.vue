<template>
    <div :class="orderStep === 1 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4 mb-sm-5">
        <div class="col-12">
            <div class="title mb-3 d-flex align-items-center gap-2">
                <i class="icon-circle-check text-success"></i>
                <h5 class="mb-0 text-uppercase fw-600 text-success">Step 1</h5>
            </div>
            <p class="fw-600 text-dark mb-4 text-capitalize">Select the Gasket Style You Need</p>
        </div>
        <div v-for="(data, index) in gasket_style" class="col-md-3 mb-3 mb-md-0" :key="index">
            <div
                @click="
                    $parent.gasketStatus = index;
                    $parent.nextStep = true;
                    $parent.getProductList(index);
                    $parent.selectedStep(index);
                "
                :class="index === gasketStatus && 'active'"
                class="gasket-type position-relative p-4 d-flex flex-column justify-content-center align-items-center"
                type="button"
            >
                <img class="w-100 mw-200" :src="getImageUrl(data)" :alt="data.name" />
                <h6 class="mb-2 fw-600">{{ data.option.title }}</h6>
                <h6 class="mb-0 fw-600">{{ data.option.type }}</h6>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
export default {
    name: 'GasketsstepOne',
    props: ['orderStep', 'stepOneProductGaskets', 'gasketStatus', 'nextStep'],
    computed: {
        ...mapState('gasket', ['gasket_style']),
    },
    methods:{
        isValidUrl(url) {
            try {
                new URL(url);
                return true;
            } catch (err) {
                return false;
            }
        },
        getImageUrl(data){
            const imgUrl = data.option.img;

            if (this.isValidUrl(imgUrl)) {
                return imgUrl;
            }

            let base_url = window.location.origin
            return base_url+'/'+imgUrl;
        }
    }
};
</script>
