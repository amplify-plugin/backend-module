import axios from 'axios'
import Api from "../apis";
import { sweetAlertToaster } from '../../modules/custom-item/helper';
import customAxios from '../../utilities/customAxios';
import { param } from 'jquery';

export const getProductType = ({ commit }) => {
    getFullPageLoader();
    customAxios.get('/custom-item/gasket/type').then((res) => {
        commit('GASKET_STYLE', res.data)
    })
    .catch((err) => {
        ShowNotification('error', 'Order', err.response.data.error);
    }).finally(() => {
        removeFullPageLoader();
    })
}

export const getProductList = ({ commit }, param) => {
    getFullPageLoader();
    customAxios.get(`/custom-item/gasket/${param}/product-list`).then((res) => {
        commit('PRODUCTS', Object.keys(res.data))
        removeFullPageLoader();
    })
        .catch((err) => {
            console.log(err)
            ShowNotification('error', 'Order', err.response.data.error);
            removeFullPageLoader();
        })
}

export const getGasketProfile = ({ commit }, param) => {
    getFullPageLoader();
    customAxios.post(`/custom-item/gasket/profile-list`, param).then((res) => {
        commit('PRODUCTS_PROFILE', res.data)
        removeFullPageLoader();
    })
        .catch((err) => {
            console.log(err)
            ShowNotification('error', 'Order', err.response.data.error);
            removeFullPageLoader();
        })
}

export const getPrice = ({ commit }, product) => {
    let code = product.product_code;
    getFullPageLoader();
    customAxios.get(`/custom-item/gasket/price?code=${code}`).then((res) => {
        commit('SET_PRODUCTS_PRICE', res.data)
        removeFullPageLoader();
    })
        .catch((err) => {
            console.log(err)
            ShowNotification('error', 'Order', err.response.data.error);
            removeFullPageLoader();
        })
}

export const setProfile = ({ commit }, param) => {
    commit('SET_PROFILE_PRODUCTS', param);
}

export const numberOfSide = ({ commit }, side) => {
    commit('SET_NUMBER_OF_SIDE', side);
}

export const setMeasurement = ({ commit }, params) => {
    commit('SET_MEASUREMENT', params);
}

export const getQuantity = ({ commit }, event) => {
    let qty = Number.isInteger(event) ? event : event.target.value;
    commit('SET_QUANTITY', qty)
}

export const setFoamFill = ({ commit }, event) => {
    let foam = event.target.value
    commit('SET_FOAM_FILL', foam)
}

export const setDoorHinged = ({ commit }, event) => {
    let hinged = event.target.value
    commit('SET_DOOR_HINGED', hinged)
}

export const addToCart = ({ state, commit, getters }, swal) => {

    let price = state.productPrice;
    let side = state.productSide;
    let depth = state.depth;
    let width = state.width;
    let depth_display = state.depth_display;
    let width_display = state.width_display;
    let qty = state.qty;
    let foam_fill = state.foam_fill;
    let door_hinged = state.door_hinged;
    let totalFeet = getters.totalFeet;
    let totalQty = getters.totalQty;
    let totalPrice = getters.totalPrice;
    let product = state.singleProfileProducts.product_code

    const [width_floor, width_fract] = state.width_display.split('-');
    const [depth_floor, depth_fract] = state.depth_display.split('-');

    let foamFill = `${foam_fill == 'Yes' ? 'FOAM FILL' : ''}`;
    let doorHinged = '';

    if(door_hinged == 'left' && foam_fill == 'Yes'){
        doorHinged = 'LH'
    }else if(door_hinged == 'right' && foam_fill == 'Yes'){
        doorHinged = 'RH'
    }
    let OrderSpec = `${qty}EA, ${width_floor} ${width_fract != undefined ? width_fract : ''} X ${depth_floor} ${depth_fract != undefined ? depth_fract : ''} ${side}S | OUTSIDE ${foamFill} ${doorHinged}`;

    const formData = new FormData();
    formData.append('price', price);
    formData.append('side', side);
    formData.append('depth', depth);
    formData.append('qty', qty);
    formData.append('width', width);
    formData.append('depth_display', depth_display);
    formData.append('width_display', width_display);
    formData.append('totalFeet', totalFeet);
    formData.append('totalQty', totalQty);
    formData.append('totalPrice', totalPrice);
    formData.append('OrderSpec', OrderSpec);
    formData.append('product', product);
    formData.append('foam_fill', foam_fill);
    formData.append('door_hinged', door_hinged);

    customAxios.post('/custom-item/gasket/add-to-cart', formData).then((res) => {
        sweetAlertToaster(swal, res.data.cart_summary, res.data.shop);
    })
        .catch((err) => {
            ShowNotification('error', 'Order', err.response.data.error);
        });

}

export const selectedStep = ({ commit }, type) => {
    commit('SELECTED_STEP', type);
}


