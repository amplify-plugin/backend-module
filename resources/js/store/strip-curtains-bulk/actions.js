import { event } from "jquery";
import Api from "../apis";
import { sweetAlertToaster } from "../../modules/custom-item/helper";
export const getStrip = ({ commit }, params) => {
    getFullPageLoader();
    Api.get('/custom-item/strip-curtains/bulk/strips').then((res) => {
        commit('setStrips', JSON.parse(res.data[0])?.items);
        commit('setProducts', JSON.parse(res.data[0])?.products);
        removeFullPageLoader();
    })
        .catch((err) => {
            ShowNotification('error', 'Order', err.response.data.error);
            removeFullPageLoader();
        });
}

export const getCurtains = ({ commit }, data) => {
    commit('setCurtains', data);
    commit('getReplacementProductPrice');
}
export const getCurtainArea = ({ commit }, event) => {
    let item = event.target.value;
    commit('setCurtainArea', item);
    commit('getReplacementProductPrice');
}

export const getQty = ({ commit }, event) => {
    let qty = Number.isInteger(event) ? event : event.target.value;
    commit('setQty', qty);
}

export const getStripLength = ({ commit, state }, event) => {
    let length = event.target.value;
    if (!length) {
        commit('stripLengthValidation', false);
        commit('setStripType', '')
        commit('setStripLength', 0);
        return;
    }
    if (state.selectedCurtains.type == state.fourInchIengths.type) {

        commit('setStripType', state.fourInchIengths)
        if (length >= state.fourInchIengths.low && length <= state.fourInchIengths.heigh) {
            commit('setStripLength', length);
            commit('stripLengthValidation', false);
        } else {
            commit('stripLengthValidation', true);
        }
    }

    if (state.selectedCurtains.type == state.sixInchIengths.type) {
        commit('setStripType', state.sixInchIengths)
        if (length >= state.sixInchIengths.low && length <= state.sixInchIengths.heigh) {
            commit('setStripLength', length);
            commit('stripLengthValidation', false);
        } else {
            commit('stripLengthValidation', true);
        }
    }

    if (state.selectedCurtains.type == state.eightInchIengths.type) {
        commit('setStripType', state.eightInchIengths)
        if (length >= state.eightInchIengths.low && length <= state.eightInchIengths.heigh) {
            commit('setStripLength', length);
            commit('stripLengthValidation', false);
        } else {
            commit('stripLengthValidation', true);
        }
    }

    if (state.selectedCurtains.type == state.twelveInchIengths.type) {
        commit('setStripType', state.twelveInchIengths)
        if (length >= state.twelveInchIengths.low && length <= state.twelveInchIengths.heigh) {
            commit('setStripLength', length);
            commit('stripLengthValidation', false);
        } else {
            commit('stripLengthValidation', true);
        }
    }
}

export const addToCart = ({ state, commit, getters }, swal) => {
    let selectedCurtains = state.selectedCurtains;
    let curtainArea = state.curtainArea;
    let replacementStripLengthInc = state.replacementStripLengthInc;
    let replacementStripLengthFeet = getters.totalFeet;

    let qty = state.replacementStripQty;
    let price = state.replacementProductPrice;
    let totalPrice = getters.totalPrice;
    let product = state.replacementProductCode;
    let OrderSpec = `${state.replacementStripQty}EA, ${replacementStripLengthFeet}FT, ${state.curtainArea} `;

    const formData = new FormData();
    formData.append('selected_curtains', selectedCurtains?.type);
    formData.append('curtain_area', curtainArea);
    formData.append('length_inc', replacementStripLengthInc);
    formData.append('length_feet', replacementStripLengthFeet);
    formData.append('total_price', totalPrice);

    formData.append('price', price);
    formData.append('qty', qty);
    formData.append('unit_price', price);
    formData.append('product', product);
    formData.append('OrderSpec', OrderSpec);
    getFullPageLoader();
    Api.post('/custom-item/strip-curtains/bulk/add-to-cart', formData).then(res => {
        removeFullPageLoader();
        sweetAlertToaster(swal, res.data.cart_summary, res.data.shop);

    })
        .catch((err) => {
            removeFullPageLoader();
            console.log(err.response.data);
            ShowNotification('error', 'Order', err.response.data.error);

        });
}
