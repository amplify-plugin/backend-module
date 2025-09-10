import { sweetAlertToaster } from "../../modules/custom-item/helper";
import customAxios from "../../utilities/customAxios";
import Api from "../apis/heater-wire/api"

export const getPrice = ({ commit }, event) => {
    let productCode = event.target.value;
    commit('setProduct',productCode);
    getFullPageLoader();
    Api.getProductByCode(productCode)
        .then(response => {
            if(!response.data.Price){
                ShowNotification('error', 'Order', 'Selling price not found!');
                commit('setPrice', 0);
            }else{
                commit('setPrice', response.data.Price);
            }
            removeFullPageLoader();
        })
        .catch(error => {
            removeFullPageLoader();
            ShowNotification('error', 'Order', error.response);
        });
}

export const getProducts = ({ commit }) => {
    getFullPageLoader();
    customAxios.get('/custom-item/heater-wire/products')
        .then(response => {
            commit('setProducts', response.data);
            removeFullPageLoader();
        })
        .catch(error => {
            removeFullPageLoader();
            ShowNotification('error', 'Order', error.response);
        });
}

export const calculateFeet = ({ commit }, event) => {
    let inches = event.target.value;
    commit('setInches', inches ?? 0);
}

export const calculateQty = ({ commit }, event) => {
    let qty = event.target.value;
    commit('setQty',qty ?? 0)
}

export const getVoltage = ({ commit }, event) => {
    let voltage = event.target.value;
    commit('setVoltage',voltage ?? 0)
}

export const getHoldingTemp = ({ commit }, event) => {
    let temp = event.target.value;
    commit('setHoldingTemp',temp ?? 0)
}

export const getWraps = ({ commit }, event) => {
    let wraps = event.target.value;
    commit('setWraps',wraps ?? 0)
}

export const addToCart = ({state, commit }, swal) => {
    let productPrice = state.productPrice;
    let totalFeet    = state.totalFeet;
    let qty          = state.qty;
    let inches       = state.inches;
    let incToFeet    = state.incToFeet;
    let totalPrice   = state.totalPrice;
    let voltage      = state.voltage;
    let temp         = state.temp;
    let wraps        = state.wraps;
    let product      = state.product;
    let OrderSpec    = `${qty}EA ,${inches}" , ${voltage}, ${temp}DEG , ${wraps == 1 ? 'SINGLE':'DOUBLE'}`;
    const formData = new FormData();
    formData.append('price',productPrice);
    formData.append('totalFeet',totalFeet);
    formData.append('qty',qty);
    formData.append('inches',inches);
    formData.append('totalPrice',totalPrice);
    formData.append('totalPrice',totalPrice);
    formData.append('voltage',voltage);
    formData.append('temp',temp);
    formData.append('wraps',wraps);
    formData.append('product',product);
    formData.append('OrderSpec',OrderSpec);
    getFullPageLoader();
    Api.addToCart(formData).then(res=>{
        removeFullPageLoader();
        sweetAlertToaster(swal,res.data.cart_summary,res.data.shop);
    })
    .catch((err)=>{
        removeFullPageLoader();
        ShowNotification('error', 'Order', err.response.data.error);

    });

    // commit('setWraps',wraps ?? 0)
}
