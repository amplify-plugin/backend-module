import Vue from 'vue';

Vue.component('ProductCreate', () => import('./views/pages/product/Create.vue'));
Vue.component('ProductClassificationCreate', () => import('./views/pages/product-classification/Create.vue'));
Vue.component('AttributeCreate', () => import('./views/pages/attribute/Create.vue'));
Vue.component('CategoryCreate', () => import('./views/pages/category/Create.vue'));
Vue.component('OptionCreate', () => import('./views/pages/options/Create.vue'));
Vue.component('CustomerGroupCreate', () => import('./views/pages/customer-group/Create.vue'));
Vue.component('ImportDefinition', () => import('./views/pages/import/definition/ImportDefinitionCreate.vue'));
Vue.component('Import', () => import('./views/pages/import/Create.vue'));
Vue.component('FaqCreate', () => import('./views/pages/faq/Create.vue'));
Vue.component('DataTransformationCreate', () => import('./views/pages/data-transformation/Create.vue'));

Vue.component('CampaignCreate', () => import('./views/pages/campaign/Create.vue'));

Vue.component('IcecatTransformationCreate', () => import('./views/pages/icecat-transformation/Create.vue'));
Vue.component('DataTransformationTestScreen', () => import('./views/pages/data-transformation/TestScreen'));
Vue.component('DataTransformationRunScreen', () => import('./views/pages/data-transformation/RunScreen'));
Vue.component('IcecatTransformationRunScreen', () => import('./views/pages/icecat-transformation/RunScreen'));
Vue.component('PageCreate', () => import('./views/pages/pages/Create.vue'));
Vue.component('SiteCreate', () => import('./views/pages/sites/Create.vue'));
Vue.component('TemplateCreate', () => import('./views/pages/templates/Create.vue'));
Vue.component('EnvSettingsCreate', () => import('./views/pages/env-settings/Create'));
Vue.component('TopBarCreate', () => import('./views/pages/top-bar/Create.vue'));
Vue.component('MerchandisingZoneCreate', () => import('./views/pages/merchandising-zones/Create.vue'));
Vue.component('MenusCreate', () => import('./views/pages/menus/Create.vue'));
Vue.component('MegamenuCreate', () => import('./views/pages/mega-menus/Create.vue'));
Vue.component('BannerCreate', () => import('./views/pages/banner/Create.vue'));
Vue.component('CmsConfigCreate', () => import('./views/pages/cms-config/Create.vue'));
Vue.component('NavigationCreate', () => import('./views/pages/navigation/Create.vue'));
Vue.component('FooterCreate', () => import('./views/pages/footer/Create.vue'));
Vue.component('InvoiceConfigCreate', () => import('./views/pages/invoice-configuration/Create.vue'));
Vue.component('SettingEmail', () => import('./views/pages/settings/SettingEmail'));
Vue.component('EventAction', () => import('./views/pages/events/Action'));
Vue.component('SelectTree', () => import('./views/components/SelectTree'));
Vue.component('ProgressBar', () => import('./views/components/ProgressBar'));
Vue.component('Configuration', () => import('./views/pages/configurations/Configuration.vue'));
Vue.component('TemplateInstall', () => import('./views/pages/templates/Install.vue'));
Vue.component('HeroSliderCreate', () => import('./views/pages/banner-slider/Create.vue'));
Vue.component('ReportCreate', () => import('./views/pages/report/Create.vue'));
Vue.component('AdhocReport', () => import('./views/pages/report/adhoc'));

// Frontend components
Vue.component('FileManager', () => import('./views/components/Filemanager'));
Vue.component('FileManagerPopup', () => import('./views/components/FilemanagerPopup'));

//Quick Item Update
Vue.component('CustomerQuickListUpdate', () => import('./views/pages/quick-lists/Update.vue'));

//Page Builder
Vue.component('pageBuilder', () => import('./modules/page-builder/Index.vue'));

//Custom Item
Vue.component('CustomItem', () => import('./modules/custom-item/custom-item.vue'));

//Contact Logins
Vue.component('ContactLoginManage', () => import('./views/pages/contact-logins/Manage.vue'));

//Order Rule Check
Vue.component('CreateCustomerOrderRule', () => import('./modules/order-rules/Create'));
Vue.component('OrderRuleCreate', () => import('./views/components/order-rule/OrderRuleCreate'));
Vue.component('OrderWaitingApproval', () => import('./views/components/order-waiting-approval/OrderWaitingApproval'));

// Checkout
Vue.component('OrderCheckout', () => import('./modules/checkout/index.vue'));
Vue.component('CustomerOrderCheckout', () => import('./modules/order-checkout/index.vue'));
Vue.component('CustomerCheckout', () => import('./modules/clients/rhsparts/checkout/index.vue'));
Vue.component('CalToolCheckout', () => import('./modules/clients/cal-tool/checkout/index.vue'));
Vue.component('DkLokCheckout', () => import('./modules/clients/dk-lok/checkout/index.vue'));
Vue.component('NudraulixCheckout', () => import('./modules/clients/nudraulix/checkout/index.vue'));
Vue.component('CodeEditor', () => import('./views/pages/code-editor.vue'));
