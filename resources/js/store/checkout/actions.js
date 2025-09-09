import axios from 'axios';
// import Api from '../apis';

export const getShippingMethod = ({ commit }, params) => {
    // commit('SET_LOADER',true);
    getFullPageLoader();
    const formData = new FormData();
    formData.append('customer_address_one', params.customer_address_one);
    formData.append('customer_address_two', params.customer_address_two);
    formData.append('customer_address_three', params.customer_address_three);
    formData.append('customer_city', params.customer_city);
    formData.append('customer_state', params.customer_state?.iso2 ?? params.customer_state);
    formData.append('customer_zipcode', params.customer_zip_code);
    formData.append('customer_country_code', params.customer_country?.iso2 ?? params.customer_country);
    formData.append('shipping_option', params.selectedShippingCheckbox);
    formData.append('shipping_method', params.shipping_method);
    formData.append('customer_phone', params.customer_phone);
    formData.append('shipping_name', params.shipping_name);
    formData.append('customer_default_warehouse', params.customer_default_warehouse);


    axios
        .post('/get/shipping/option', formData)
        .then((res) => {
            commit('SET_SHIPPING', res.data);
            // commit('SET_LOADER',false);
            removeFullPageLoader();
        })
        .catch((err) => {
            removeFullPageLoader();
            ShowNotification('error', 'Order', err.response.data.error);
        });
};
