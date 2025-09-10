import { event } from "jquery";
import Api from "../apis";
import { sweetAlertToaster } from "../../modules/custom-item/helper";
export const getStrip = ({ commit }, params) => {
    getFullPageLoader();
    Api.get('/custom-item/strip-replacement/strips').then((res)=>{
        let data = JSON.parse(res.data[0]);
        commit('setStrips', data?.items);
        commit('setProducts', data?.products);
        removeFullPageLoader();
    })
    .catch((err)=>{
        ShowNotification('error', 'Order', err.response.data.error);
        removeFullPageLoader();
    });
}

export const getCurtains = ({commit},data) => {
    commit('setCurtains',data);
    commit('getReplacementProductPrice');
}
export const getCurtainArea = ({commit},event) => {
    let item = event.target.value;
    commit('setCurtainArea',item);
    commit('getReplacementProductPrice');
}

export const getStripLength = ({commit,state},event) =>{
    let length = event.target.value;
    if(!length){
        commit('stripLengthValidation',false);
        commit('setStripType','')
        commit('setStripLength',0);
        return;
    }

    if(state.selectedCurtains.type == state.fourInchIengths.type){

        commit('setStripType',state.fourInchIengths)
        if(length >= state.fourInchIengths.low && length <= state.fourInchIengths.heigh){
            commit('setStripLength',length);
            commit('stripLengthValidation',false);
        }else{
            commit('stripLengthValidation',true);
        }
    }

    if(state.selectedCurtains.type == state.sixInchIengths.type){
        commit('setStripType',state.sixInchIengths)
        if(length >= state.sixInchIengths.low && length <= state.sixInchIengths.heigh){
            commit('setStripLength',length);
            commit('stripLengthValidation',false);
        }else{
            commit('stripLengthValidation',true);
        }
    }

    if(state.selectedCurtains.type == state.eightInchIengths.type){
        commit('setStripType',state.eightInchIengths)
        if(length >= state.eightInchIengths.low && length <= state.eightInchIengths.heigh){
            commit('setStripLength',length);
            commit('stripLengthValidation',false);
        }else{
            commit('stripLengthValidation',true);
        }
    }
}

export const getQty = ({commit},event) =>{
    let qty = Number.isInteger(event)?event:event.target.value;
    commit('setQty',qty);
}

export const addToCart = ({state,commit,getters},swal)=> {
    let qty = state.replacementStripQty;
    let totalPrice = getters.totalPrice;
    let price = state.replacementProductPrice;
    let product = state.replacementProductCode;
    let feet = state.replacementStripLengthFeet;
    let OrderSpec = `${state.replacementStripQty}EA, ${state.replacementStripLengthInc}L, ${state.curtainArea} `;

    const formData = new FormData();
    formData.append('price',price);
    formData.append('qty',qty);
    formData.append('totalPrice',totalPrice);
    formData.append('price',price);
    formData.append('product',product);
    formData.append('OrderSpec',OrderSpec);
    formData.append('feet',feet);

    Api.post('/custom-item/strip-replacement/add-to-cart',formData).then(res=>{
        sweetAlertToaster(swal,res.data.cart_summary,res.data.shop);
    })
    .catch((err)=>{
        console.log(err);
        ShowNotification('error', 'Order', err.response.data.error);

    });
}
