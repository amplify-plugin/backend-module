<template>
    <div class="form-group col-sm-4 pr-0 pt-3 custom-border-right">

        <div class="w-100 mb-2 d-flex justify-content-between pr-3">
            <label class="mb-0">Filter Products</label>
            <button class="btn btn-default btn-sm" type="button"
                    @click="$parent.resetData(true);"
                    data-toggle="tooltip" data-placement="top" title="Reset Search">
                <i class="la la-history"></i>
            </button>
        </div>

        <div id="searchModalLeft" class="w-100 d-flex justify-content-between row">
            <div class="form-group col-sm-12 pr-0">
                <div class="custom-border rounded position-relative">
                    <div v-if="$parent.$parent.$parent.searching" class="wait"></div>
                    <div class="mb-0 p-2 pr-2 border-bottom bg-light rounded-top">
                        <strong class="m-0 custom-sub-title d-flex justify-content-between">
                            <span class="pr-3">
                                Category
                            </span>
                            <span class="pr-1 d-flex my-auto">
                                <span class="badge rounded badge-primary">
                                    {{ $parent.categoryOptions.length }}
                                </span>
                            </span>
                        </strong>
                    </div>
                    <div v-if="$parent.categoryOptions.length" class="product-attribute">
                        <div v-for="(category, index) in $parent.categoryOptions" class="my-1 px-1">
                            <div :for="`cat-${index}`"
                                 @click="$parent.selectedCategory(category);
                                 ['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes($parent.calledFrom)
                                 ? $parent.$parent.setCategoryNavPath(category)
                                 : $parent.$parent.$parent.setCategoryNavPath(category)"
                                 class="cursor-pointer mb-0 hover-me pl-1 rounded d-flex justify-content-between">
                                <div class="pr-3">
                                    {{ category.name }}
                                </div>
                                <div class="pr-2 d-flex my-auto">
                                    <div class="badge rounded badge-primary" v-if="category.productCount >= 0">
                                        {{ category.productCount }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="!$parent.categoryOptions.length"
                         class="text-center custom-sub-title py-2">
                        No Category Found
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-12 pr-0"
                 v-if="$parent.type !== 'category'"
                 v-for="(attributeValues, index) in $parent.attributeOptions">
                <div class="custom-border rounded position-relative">
                    <div v-if="$parent.$parent.$parent.searching" class="wait"></div>
                    <div class="mb-0 p-2 pr-2 border-bottom bg-light rounded-top">
                        <strong class="m-0 custom-sub-title d-flex justify-content-between">
                            <div class="pr-3">
                                {{ attributeValues.name }}
                            </div>
                            <div class="d-flex">
                                <div class="pr-1 d-flex my-auto">
                                    <div class="badge rounded badge-primary">
                                        {{ attributeValues.attributeValueList.length }}
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-default py-0"
                                        v-show="attributeValues.attributeValueList.length > 5"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        :data-original-title="attributeValues.isInitDispLimited
                                                                    ? 'More'
                                                                    : 'Less'"
                                        role="button"
                                        @click="attributeValues.isInitDispLimited = !attributeValues.isInitDispLimited;
                                                                    $parent.renderTooltip();">
                                    {{
                                        attributeValues.isInitDispLimited
                                        ? '+'
                                        : '-'
                                    }}
                                </button>
                            </div>
                        </strong>
                    </div>
                    <div v-if="attributeValues.attributeValueList.length" class="">
                        <div v-for="(attribute, indexInner) in attributeValues[
                                                            attributeValues.isInitDispLimited
                                                            ? 'initialAttributeValueList'
                                                            : 'attributeValueList'
                                                        ]"
                             class="my-1 px-1">

                            <div v-if="attributeValues.name === 'Price'" class="d-flex justify-content-between">

                                <div class="w-100">
                                    <VueSimpleRangeSlider
                                        class="slider w-100"
                                        :min="attribute.minRangeValue"
                                        :max="attribute.maxRangeValue"
                                        barColor="#d9e2ef"
                                        activeBarColor="#7c69ef"
                                        :logarithmic="true"
                                        v-model="sliderValue"
                                    />
                                </div>
                                <div class="pr-2 d-flex my-auto">
                                    <div class="badge rounded badge-primary">
                                        {{ attribute.productCount }}
                                    </div>
                                </div>
                            </div>
                            <label v-else :for="`attr-${index}-${indexInner}`"
                                   @input="$parent.selectedBrand(attribute)"
                                   class="cursor-pointer mb-0 hover-me pl-1 rounded d-flex justify-content-between font-weight-normal">

                                <div class="pr-3">
                                    <input :type="attribute.singleValued ? 'radio' : 'checkbox'"
                                           :id="`attr-${index}-${indexInner}`"
                                           v-model="attribute.checked"
                                           class=" checkedProducts my-auto mr-2">
                                    {{ attribute.attributeValue }}
                                </div>
                                <div class="pr-2 d-flex my-auto">
                                    <div class="badge rounded badge-primary">
                                        {{ attribute.productCount }}
                                    </div>
                                </div>

                            </label>

                        </div>
                    </div>
                    <div v-else
                         class="text-center custom-sub-title py-2 text">
                        No {{ attributeValues.name }} found
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import VueSimpleRangeSlider from 'vue-simple-range-slider';
import 'vue-simple-range-slider/dist/vueSimpleRangeSlider.css';
import _                    from "lodash";

export default {
    name      : "Left",
    components: {
        VueSimpleRangeSlider,
    },
    data() {
        return {
            sliderValue: [0, 99999999],
            priceIndex : 1,
        }
    },
    methods: {
        async filterPrice(index, indexInner) {
            let attribute      = _.cloneDeep(this.$parent.attributeOptions[index].attributeValueList[indexInner]);
            let nodeString     = `Price:Between-${this.sliderValue[0]}-and-${this.sliderValue[1]}`
            let nodeStringSend = `Price:${this.sliderValue[0]}-${this.sliderValue[1]}-${attribute.minRangeValue}-${attribute.maxRangeValue}`

            attribute = {
                ...attribute,
                ...{
                    attributeValue: `Between ${this.sliderValue[0]} and ${this.sliderValue[1]}`,
                    maxValue      : this.sliderValue[1],
                    minValue      : this.sliderValue[0],
                    nodeString    : nodeStringSend,
                    seoPath       : `${attribute.seoPath}/${nodeStringSend}`,
                }
            };

            if (!this.$parent.$parent.$parent.searching) {
                await this.$parent.selectedBrand(attribute);
            }
        }
    },
    watch  : {
        sliderValue: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.filterPrice(this.priceIndex, 0);
            }
        }
    },
}
</script>

<style lang="scss">
.slider {
    .simple-range-slider-bg-bar {
        margin-bottom: 16px !important;
        margin-top: 38px !important;

        .simple-range-slider-popover {
            padding-top: 0;
            padding-bottom: 0;
            padding-left: 7px;

            label {
                margin: 0;
            }
        }
    }
}
</style>
