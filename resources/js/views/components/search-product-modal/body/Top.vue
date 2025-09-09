<template>
    <div class="form-group col-sm-12 mb-0">

        <!-- Pagination -->
        <div class="w-100 d-flex justify-content-between my-2">
            <div>
                <label class="m-0">
                    {{ labelSearchProducts }} <i
                    v-if="['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes(this.calledFrom)? $parent.$parent.searching : $parent.$parent.$parent.searching"
                    class="la la-spinner la-pulse"></i>
                    <small>
                        (Showing {{ $parent.pagination.firstItem }} to
                        {{ $parent.pagination.lastItem }} of
                        {{ $parent.pagination.totalItems }} items)
                    </small>
                </label>

                <div v-if="!fromSelectedList" class="checkbox my-0 my-lg-2 ml-2">
                    <input v-if="['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes(this.calledFrom)" id="return_skus" type="checkbox"
                           v-model="$parent.$parent.returnSKUS" @click="$parent.$parent.returnSKUSClicked = true;">
                    <input v-else id="return_skus" type="checkbox" v-model="$parent.$parent.$parent.returnSKUS"
                           @click="$parent.$parent.$parent.returnSKUSClicked = true;">
                    <label for="return_skus" class="form-check-label font-weight-normal">Return SKUS </label>
                </div>
            </div>

            <div class="pagination">
                <span class="btn btn-outline-default mr-1"
                      :class="$parent.pagination.currentPage <= 1
                          ? 'disabled'
                          : 'text-dark cursor-pointer'"
                      @click="$parent.changeCurrentPage(false)"
                      :title="`${$parent.pagination.currentPage <= 1
                                    ? ''
                                    : 'Previous (' + ($parent.pagination.currentPage - 1) + ')'}`">
                    <i class="la la-less-than"></i>
                </span>
                <select v-model="$parent.pagination.resultsPerPage"
                        class="rounded border border-secondary"
                        title="Results Per Page"
                        @change="onChangePaginationDropdown()">
                    <option :value="perPage" v-for="perPage in $parent.perPages" :key="perPage">
                        {{ perPage }}
                    </option>
                </select>
                <span class="btn btn-outline-default ml-1"
                      :class="$parent.pagination.currentPage >= $parent.pagination.pageCount
                                                      ? 'disabled'
                                                      : 'text-dark cursor-pointer'"
                      @click="$parent.changeCurrentPage(true)"
                      :title="`${$parent.pagination.currentPage >= $parent.pagination.pageCount
                                                                ? ''
                                                                : 'Next (' + ($parent.pagination.currentPage + 1) + ')'}`">
                    <i class="la la-greater-than"></i>
                </span>
            </div>
        </div>

        <!-- Viewing -->
        <label v-if="!fromSelectedList" class="d-block my-2 w-100">
            <span class="mr-1"> Viewing: </span>
            <small
                v-for="(nav, navIndex) in ['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes($parent.calledFrom)? $parent.$parent.navPath : $parent.$parent.$parent.navPath"
                :key="navIndex">
                <span class="cursor-pointer text-hover-danger"
                      data-toggle="tooltip"
                      data-placement="top"
                      @click="removeNav(nav, navIndex)"
                      :data-original-title="`${!!navIndex ? 'Remove ' + nav.value.replace(/@/g, ' ') : 'Reset Search'}`">
                    {{ nav.value.replace(/@/g, ' ') }}
                </span>
                <span
                    v-if="navIndex + 1 !== (['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes($parent.calledFrom)? $parent.$parent.navPath.length : $parent.$parent.$parent.navPath.length)">
                    /
                </span>
            </small>
        </label>

        <!-- Searching input -->
        <input type="text" class="form-control"
               :readonly="['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes($parent.calledFrom)? $parent.$parent.searching : $parent.$parent.$parent.searching"
               v-model="site_search"
               placeholder="Search Text...">

    </div>
</template>

<script>
import _ from "lodash";

export default {
    name : "Top",
    props: {
        fromSelectedList: {
            default: false
        },
        calledFrom      : {
            default: null,
        },
    },
    data() {
        return {
            site_search        : '',
            labelSearchProducts: 'Filter Products',
        }
    },
    mounted() {
        this.initialSetup();
    },
    methods : {
        removeNav(nav, index) {

            if (!!index) {
                if (this.$parent.calledFrom === 'productModule') {
                    let seoPathArray     = nav.seoPath.split('/');
                    let fullSeoPathArray = _.last(this.$parent.$parent.$parent.navPath).seoPath.split('/');
                    let seoPath          = fullSeoPathArray.filter(seoPath => _.last(seoPathArray) !== seoPath).join('/');

                    !!seoPath
                    ? this.$parent.$parent.$parent.getEasyAskProducts(null, seoPath)
                    : this.doSomeReset(true)

                    this.$parent.$parent.$parent.removeNavPath(index);
                    this.removeFromLocal();

                } else if (['categoryModule', 'productClassificationModule'].includes(this.$parent.calledFrom)) {
                    this.$parent.isSeoPathRemoved = this.$parent.$parent.$parent.isSearchStringExist(nav.seoPath);
                    this.$parent.$parent.$parent.removeNavPath(index);
                    this.$parent.$parent.$parent.reStructureSeoPath(nav.seoPath);
                } else if (['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes(this.$parent.calledFrom)) {
                    this.$parent.isSeoPathRemoved = this.$parent.$parent.isSearchStringExist(nav.seoPath);
                    this.$parent.$parent.removeNavPath(index);
                    this.$parent.$parent.reStructureSeoPath(nav.seoPath);
                }
            } else {
                this.doSomeReset(true);
            }

        },

        doSomeReset(resetSiteSearch = false) {
            this.$parent.resetData(resetSiteSearch);
            ['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes(this.$parent.calledFrom)
            ? this.$parent.$parent.resetNavPath()
            : this.$parent.$parent.$parent.resetNavPath();
        },

        removeFromLocal() {

        },

        onChangePaginationDropdown() {
            this.$parent.pagination.currentPage = 1;

            if (this.fromSelectedList) {
                this.$parent.setDebounce(this.fromSelectedList, this.site_search)
            } else {
                ['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes(this.$parent.calledFrom)
                ? this.$parent.$parent.getEasyAskProducts()
                : this.$parent.$parent.$parent.getEasyAskProducts();
            }
        },

        initialSetup() {
            if (this.calledFrom === 'categoryModule') {
                this.labelSearchProducts = 'Filter Products In Category'
            } else if (this.calledFrom === 'productModule') {
                this.labelSearchProducts = this.module === 'products' ? 'Filter Bundle Products' : 'Filter Products';
            } else if (this.calledFrom === 'SKUS') {
                this.labelSearchProducts = 'Filter SKU Products'
            } else if (this.calledFrom === 'productClassificationModule') {
                this.labelSearchProducts = 'Filter Products In Product Classification'
            }
        }
    },
    computed: {
        _() {
            return _;
        }
    },
    watch   : {
        site_search: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                if (this.fromSelectedList) {
                    this.$parent.$parent.site_search = newVal
                } else {
                    if (['dataTransformationTestScreen', 'megaMenuScreen', 'campaignScreen'].includes(this.calledFrom)) {
                        this.$parent.$parent.site_search = newVal
                    } else {
                        this.$parent.$parent.$parent.site_search = newVal
                    }
                }

                this.$parent.setDebounce(this.fromSelectedList, newVal);
            }
        }
    },
}
</script>

<style scoped>

</style>
