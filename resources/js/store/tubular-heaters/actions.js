import { sweetAlertToaster } from "../../modules/custom-item/helper";
import Api from "../apis";
export const setConfiguration = ({ commit }, val) => {
    commit('SET_CONFIGURATION', val);
}
export const setMeasurement = ({ commit }, params) => {
    commit('CHANGE_PRODUCT')
    commit('SET_MEASUREMENT', params)
}
export const getSingleProduct = ({ commit }, item) => {
    let product = item.product;
    getFullPageLoader();
    Api.get(`/custom-item/tubular-heater/product/${product}`).then((res) => {
        if (!res.data.Price) {
            ShowNotification('error', 'Order', 'Selling price not found!');
            state.selling_price = 0;
        } else {
            commit('SET_PRODUCT_PRICE', res.data.Price)
            commit('SET_PRODUCT', item)
            commit('SET_QUANTITY', 1)
        }
        removeFullPageLoader();
    })
        .catch((err) => {
            removeFullPageLoader();
            ShowNotification('error', 'Order', err.response.data.error);

        });
}
export const changeProduct = ({ commit }) => {
    commit('CHANGE_PRODUCT')
}

export const setQuantity = ({ commit }, qty) => {
    commit('SET_QUANTITY', qty)
}
export const addToOrder = ({ state, commit, getters }, swal) => {
    let configuration = state.configuration.title;
    let product = state.product.product;
    let price = state.price;
    let qty = state.qty;
    let totalPrice = getters.totalPrice;
    let totalInc = getters.totalInc;
    let measurements = getters.inputedMeasurement;
    let roll = state.roll;
    let config = ['A', 'B', 'C'];
    let spec = '';
    measurements.forEach((el, index) => {
        let dispalyVal = el.dispaly
        spec += `${config[index]}=${dispalyVal} ,`;
        let lastIndex = spec.lastIndexOf(",");
        if (lastIndex !== -1) {
            spec = spec.slice(0, lastIndex) + spec.slice(lastIndex + 1);
        }
    });
    let OrderSpec = `${qty}EA, CON=${state.configuration.id} ${roll=='yes'?', ROLL':''}|${spec}`;
    const formData = new FormData();
    formData.append('configuration', configuration);
    formData.append('product', product);
    formData.append('price', price);
    formData.append('qty', qty);
    formData.append('totalPrice', totalPrice);
    formData.append('totalInc', totalInc);
    formData.append('OrderSpec', OrderSpec);
    // dispaly comman value
    formData.append('uom', 'EA');
    formData.append('display_qty', qty);
    formData.append('display_price', price);
    formData.append('display_total_price', totalPrice);
    getFullPageLoader();
    Api.post('/custom-item/tubular-heater/add-to-cart', formData).then((res) => {
        removeFullPageLoader();
        sweetAlertToaster(swal, res.data.cart_summary, res.data.shop);
    })
        .catch((err) => {
            removeFullPageLoader();
            ShowNotification('error', 'Order', err.response.data.error);

        });
}
export const getProduct = ({ commit }, num) => {
    Api.get(`/custom-item/tubular-heater/products/${num}`).then((res) => {
        commit('GET_PRODUCTS', res?.data)
    })
        .catch((err) => {
            ShowNotification('error', 'Order', err.response.data.error);

        });
}

export const getRoll = ({commit},event) =>{
    commit('GET_ROLL', event.target.value)
}

