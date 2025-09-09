<template>
    <div>
        <div class="mt-3">
            <div class="card mb-3">
                <div class="card-body row mb-0 pb-0">
                    <SearchSkuModal ref="searchSkuModal"/>

                    <Bottom ref="bottom"
                            calledFrom="SKUS"
                            :getProducts="$parent.getEasyAskProducts"
                            dataTarget="#addSkuProductModal"
                            :getModal="getModal"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _              from "lodash";
import Bottom         from "../../../../components/selected-products/Bottom";
import SearchSkuModal from "../../../../components/search-sku-product-modal/SearchSkuProductModal";

export default {
    name      : "Selector",
    components: {Bottom, SearchSkuModal},
    data() {
        return {
            timer                : null,
            search_by_product_id : null,
            getModal             : null,
            getSKUProductsListUrl: this.$parent.skuProductSearchURL,
            settings                    : {
                view: null
            },
            defaultSettings             : {
                view: 'grid'
            },
        }
    },

    mounted() {
        this.$root.renderTooltip();

        this.getModal = this.$refs.searchSkuModal.getModal;
        this.getSettings();
    },

    methods: {
        onChangePaginationDropdown() {
            this.$parent.pagination.currentPage = 1;
            this.setDebounce(false, this.site_search)
        },

        setDebounce(fromSelectedList = false, site_search = null) {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                if (fromSelectedList) {
                    this.getSKUProductsList(site_search);
                } else {
                    this.$parent.getEasyAskProducts();
                }
            }, 1000)
        },

        setSettings(key, value, setDefault = false) {
            if (setDefault) {
                this.settings = _.cloneDeep(this.defaultSettings);
            } else {
                this.settings[key] = value;
            }

            localStorage.setItem('settings', JSON.stringify(this.settings));
            return this;
        },

        getSettings() {
            let settings = localStorage.getItem('settings');
            if (settings)
                this.settings = JSON.parse(settings);
            else
                this.setSettings(false, false, true);
        },

        changeCurrentPage(next = true) {
            let currentPage = this.pagination.currentPage;

            next && this.pagination.currentPage < this.pagination.pageCount
            ? this.pagination.currentPage++
            : false;

            !next && this.pagination.currentPage > 1
            ? this.pagination.currentPage--
            : false;

            let site_search = null;
            if (this.fromSelectedList) {
                site_search = this.$refs.top.site_search;
            }

            currentPage !== this.pagination.currentPage
            ? this.getSKUProductsList(site_search)
            : false;
        },

        getSKUProductsList(search = null) {
            let pagination = this.$parent.pagination;
            let params     = {
                parent_id : this.$parent.parent_id,
                search    : search ?? '',
                pagination: pagination,
                page      : this.$parent.pagination.currentPage,
                calledFrom: 'selector',
            };

            axios.post(this.getSKUProductsListUrl, params)
                .then(({data}) => {
                    this.$parent.listsSKUProducts = Object.values(data.data);
                    this.$parent.pagination               = {
                        currentPage   : data.current_page,
                        firstItem     : data.from,
                        lastItem      : data.to,
                        pageCount     : data.last_page,
                        resultsPerPage: data.per_page,
                        totalItems    : data.total,
                    };
                    this.$parent.reRenderListTable++;
                })
                .catch(error => {
                    new Noty({
                        type: "error",
                        text: error.message
                    }).show();
                });
        },

        resetData() {
            this.$refs.top.site_search = '';
            this.$parent.pagination            = _.cloneDeep(this.$parent.paginationBackup);
            this.getSKUProductsList();

            new Noty({
                type: "success",
                text: 'Reset Successful!',
            }).show()
        },
    },

    watch: {
        //SKUProductLoader:
    },

    computed: {},
}
</script>

<style scoped>
</style>
