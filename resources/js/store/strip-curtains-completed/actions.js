import { sweetAlertToaster } from "../../modules/custom-item/helper";
import Api from "../apis";

export const validateMeasurement = ({commit,state},data) => {
    commit('SET_MESSAGE_BOX',false);
    let height = data.event.target.value
    if(
        state.stripWidth == state.fourInchWidth.type &&
        height >= state.fourInchWidth.low &&
        height <= state.fourInchWidth.heigh
    ){
        commit('SET_MESSAGE_BOX',false);
        return;
    }

    if(
        state.stripWidth == state.sixInchWidth.type &&
        height >= state.sixInchWidth.low &&
        height <= state.sixInchWidth.heigh
    ){
        commit('SET_MESSAGE_BOX',false);
        return;
    }

    if(
        state.stripWidth == state.eightInchWidth.type &&
        height >= state.eightInchWidth.low &&
        height <= state.eightInchWidth.heigh
    ){
        commit('SET_MESSAGE_BOX',false);
        return;
    }

    if(
        state.stripWidth == state.twelveInchWidth.type &&
        height >= state.twelveInchWidth.low &&
        height <= state.twelveInchWidth.heigh

    ){
        commit('SET_MESSAGE_BOX',false);
        return;
    }

    commit('SET_MESSAGE_BOX',true);
}

export const setMeasurement = ({commit,state},data) => {
    commit('SET_MEASUREMENT',data);
}



export const setValidationMsg = ({commit}) => {
    commit('SET_MESSAGE_BOX',true);
}

export const setStripWidth = ({commit},event) => {
    let val = event.target.value;
    commit('SET_STRIP_WIDTH',val);
    // commit('SET_MESSAGE_BOX',true);
    commit('SET_PRICE');
}

export const setCurtainArea = ({commit},event) => {
    let val = event.target.value;
    commit('SET_CURTAIN_AREA',val);
    commit('SET_PRICE');
}

export const cutMountingBar=({commit},event)=>{
    let val = event.target.value;
    commit('SET_MOUNTING_BAR',val);
}

export const getQuantity = ({commit},event) => {
    let val = Number.isInteger(event)?event:event.target.value;
    if(val < 1){
        commit('SET_QUANTITY','');
        ShowNotification('error', 'Order', 'Range must be 01 to 100');
    }else if(val>100){
        commit('SET_QUANTITY','');
        ShowNotification('error', 'Order', 'Range must be 01 to 100');
    }else{
        commit('SET_QUANTITY',val);
    }
}

export const addToCart = ({state,commit,getters},swal)=> {
    let qty = state.quantity;
    let totalPrice = getters.totalPrice;
    let price = state.productPrice;
    let product = state.product;
    let depth = state.depth;
    let height = state.height;

    let isCutBar = state.is_mounting_bar == 1?'CUT BAR FOR SHIPPING':'DO NOT CUT BAR FOR SHIPPING';
    let OrderSpec = `${qty}EA,${state.depth} W X ${state.height} L, ${state.curtainArea} , ${state.stripWidth}, ${isCutBar} `;
    const formData = new FormData();
    formData.append('price',price);
    formData.append('height',height);
    formData.append('depth',depth);
    formData.append('qty',qty);
    formData.append('totalPrice',totalPrice);
    formData.append('product',product);
    formData.append('OrderSpec',OrderSpec);
    Api.post('/custom-item/strip-curtains/completed/add-to-cart',formData).then(res=>{
        sweetAlertToaster(swal,res.data.cart_summary,res.data.shop);
    })
    .catch((err)=>{
        console.log(err.response);
        ShowNotification('error', 'Order', err.response.data.error);

    });
}
