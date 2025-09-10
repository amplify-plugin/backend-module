<template>
    <div :class="orderStep === 1 ? 'order-step-block' : 'order-step-d-none'" class="row mb-4">
        <div class="col-12">
            <div class="title mb-3 d-flex align-items-center gap-2">
                <i
                    :class="[$parent.completedSection.includes(1) ? 'text-success' : 'text-black-50']"
                    class="icon-circle-check"
                ></i>
                <h5
                    :class="[$parent.completedSection.includes(1) ? 'text-success' : 'text-danger']"
                    class="mb-0 text-uppercase fw-600"
                >
                    Step 1
                </h5>
            </div>
            <p class="fw-600 text-dark mb-4 text-capitalize">Order Custom Tubular Heater</p>
        </div>
        <div v-for="(data, index) in stepTwoProductRetainer" class="col-md-3 mb-4" :key="index">
            <div
                @click="
                    $parent.slectedTubularHeaters = data;
                    $parent.nextStep = true;
                "
                :class="data.title === slectedTubularHeaters.title && 'active'"
                class="gasket-type position-relative p-4 d-flex flex-column justify-content-center align-items-center"
                type="button"
            >
                <img class="w-100 mw-200" :src="'/frontend/rhsparts/images/' + data.img" :alt="data.title" />
                <h6 class="fw-600">{{ data.title }}</h6>
            </div>
        </div>
        <div class="col-md-12 mb-4">
            <span class="text-danger"
                ><b>Note:</b> Never connect 115V heaters directly to 230V Current. Do NOT mix different wattage heaters
                for series circuits. Always use heaters of the same voltage and wattage when wiring series
                circuits.</span
            >
        </div>
    </div>
</template>
<script>
export default {
    name: 'step-2',
    props: ['slectedTubularHeaters', 'orderStep', 'stepTwoProductRetainer', 'nextStep'],
};
</script>
