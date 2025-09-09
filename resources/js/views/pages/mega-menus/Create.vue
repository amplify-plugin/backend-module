<template>
    <div class="row">
        <div :class="class_name">
            <!-- Default box -->
            <form method="post" @submit.prevent="" :action="backUrl">
                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                <div class="card">
                    <div class="card-body">
                        <div v-if="form.errors.any()" class="alert alert-danger pb-0">
                            <ul class="list-unstyled">
                                <div v-for="(error, index) in $parent.form.errors" :key="index">
                                    <li v-for="(message, index) in error" :key="index">
                                        <i class="la la-info-circle"></i>
                                        {{ message[0] }}
                                    </li>
                                </div>
                            </ul>
                        </div>
                        <FormFields ref="formFields"></FormFields>
                    </div>
                </div>

                <div id="saveActions" class="form-group" v-if="method !== 'get'">
                    <input type="hidden" name="save_action" v-model="actionType"/>

                    <button @click="actionType = 'save_and_back';saveData();" type="button" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span>
                        &nbsp;
                        <span data-value="save_and_edit"> Save and Back</span>
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
import _ from "lodash";
import Form from "../../../utilities/Form";
import FormFields from "./FormFields";

export default {
    name: "MegaMenuCreate",
    components: {FormFields},

    props: ["class_name", "url", "method", "axios_url", "category_url", "mega_menu", 'mega_menu_types', 'merchandising_zones', "categories", "menu", 'available_menu_column'],
    data() {
        return {
            form: new Form({
                name: "",
                menu_column_size: 4,
                links: [
                    {
                        name: "",
                        link: "",
                    },
                ],
                menu_id: "",
                category_id: "",
                category_seopath: "",
                number_of_categories: "",
                merchandising_zone_id: "",
                merchandising_attribute_access: {
                    name: true,
                    image: true,
                    price: true,
                    short_desc: true,
                },
                number_of_merchandising_products: "",
                number_of_column_merchandising_zone: "",
                products: [],
                html_content: "",
                type: "default",
                enabled: true,
                show_name: false,
                only_featured_manufacturer: true,
            }),
            defaultProductColumnSize: 4,
            defaultProductAttributeAccess: {
                name: true,
                image: true,
                price: true,
                short_desc: true,
            },
            isSearchModalCompMount: false,
            merchandisingZones: [{'id': null, 'name': null}],
            categoriesForSubCategory: [],
            megaMenu: {},
            menuId: "",
            backUrl: "/admin/mega-menu?menuId=" + JSON.parse(this.menu).id,
            newUrl: "/admin/mega-menu/create?menuId=" + JSON.parse(this.menu).id,
            actionType: "save_and_back",
            megaMenuTypes: JSON.parse(this.mega_menu_types)
        };
    },

    mounted() {
        axios.get(this.category_url)
            .then(response => {
                this.categoriesForSubCategory = response.data;
            });

        this.menuId = JSON.parse(this.menu).id;
        this.megaMenu = JSON.parse(this.mega_menu);
        this.merchandisingZones = JSON.parse(this.merchandising_zones);
        this.categoriesForSubCategory = JSON.parse(this.categories);
        this.form.menu_id = JSON.parse(this.menu).id;

        if (this.method !== "post") {
            this.initEdit();
        }

    },
    methods: {
        initEdit() {
            this.form = new Form({
                name: this.megaMenu.name,
                menu_column_size: this.megaMenu.menu_column_size,
                links: this.megaMenu.links ? JSON.parse(this.megaMenu.links) : [
                    {
                        name: "", link: "",
                    },
                ],
                menu_id: this.megaMenu.menu_id,
                show_name: this.megaMenu.show_name,
                category_id: this.megaMenu.category_id,
                category_seopath: this.megaMenu.category_seopath,
                number_of_categories: this.megaMenu.number_of_categories,
                merchandising_zone_id: this.megaMenu.merchandising_zone_id,
                only_featured_manufacturer: this.megaMenu.only_featured_manufacturer,
                merchandising_attribute_access: this.megaMenu.merchandising_attribute_access ?? {
                    name: true,
                    image: true,
                    price: true,
                    short_desc: true,
                } ,
                number_of_merchandising_products: this.megaMenu.number_of_merchandising_products,
                number_of_column_merchandising_zone: this.megaMenu.number_of_column_merchandising_zone,
                products: this.megaMenu.products.map(product => {
                    return {
                        product_id: product.product_id,
                        attribute_access: product.attribute_access,
                        product_column_size: product.product_column_size
                    };
                }),
                html_content: this.megaMenu.html_content,
                type: this.megaMenu.type,
                enabled: this.megaMenu.enabled,
            });
        },
        mountedChild() {
            if (this.method !== "post" && !this.isSearchModalCompMount) {
                this.isSearchModalCompMount = true;
                this.$refs.formFields.getModal = this.$refs.formFields.$refs.searchModal.getModal;
                for (const product of this.form.products) {
                    this.$refs.formFields.getEasyAskProducts(product.product_id, false, product.attribute_access, product.product_column_size);
                }
            }
        },
        saveAndAction(argument) {
            if (argument === "cancel") {
                window.location = "/admin/mega-menu?menuId=" + this.menuId;
            }
        },

        saveData() {
            this.form
                .submit(this.method, this.axios_url)
                .then((res) => {

                    new Noty({
                        type: "success",
                        text: "Saved successfully",
                    }).show();

                    window.location = this.actionType === "save_and_back" ? this.backUrl : this.newUrl;
                })
                .catch((error) => {
                    new Noty({
                        type: "error",
                        text: error.message,
                    }).show();
                });
        },
    },
};
</script>

<style scoped>
</style>
