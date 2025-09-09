import axios from 'axios'
import { generateProduct, getWireSelfPrice } from "../helper"
import customAxios from "../../utilities/customAxios";

export const setDepth = (state, depth) => {
    if(depth.step =='input-one'){
        state.shelf_depth = Math.ceil(depth.val)
        state.depth_display = depth.dispaly
    }
    if(depth.step =='input-two'){
        state.shelf_width = Math.ceil(depth.val)
        state.width_display = depth.dispaly
    }
}

export const setDiameter = (state, diameter) => {
    state.diameter = diameter;
}

export const setFinish = (state, finish) => {
    state.finish = finish;
}

export const setPrice = async (state, price) => {
    let product = generateProduct(state);

    let depth = Number(state.shelf_depth);
    let width = Number(state.shelf_width);
    let tier = Number(depth * width);
    let finish = state.finish;
    let diameter = state.diameter;
    let tierType = '';

    if (tier < state.t1) {
        tierType = 'T1';
    }
    else if (tier > state.t1 && tier < state.t2) {
        tierType = 'T2';
    }
    else if (tier > state.t2) {
        tierType = 'T3';
    }
    if (tierType) {
        let product= `${finish}-${diameter}${tierType}`;
    }

    var formData = {
        "diameter":state.diameter,
        "finish":state.finish,
        "product":product,
    }
    if(state.diameter && state.finish && product){
        getFullPageLoader();
        state.loader = true;
        await customAxios.post('/custom-item/shelving/product/price',formData).then((res)=>{
            state.original_price = res.data.original_price;
            state.minimum_price = res.data.minimum_price;
            state.product = res.data.product;
            state.loader = false;
            removeFullPageLoader();
           })
           .catch((err)=>{
            removeFullPageLoader();
            ShowNotification('error', 'Order', err.response);
           })
           state.loader = false;
    }
}

export const setQty = (state, qty) => {
    state.qty = qty;
}

export const setProduct = (state,code) => {
    state.product = code;
}
export const removeData = (state , data) => {
    if(data == 'input-two'){
        state.shelf_width = 0;
        state.width_fract = 0;
        state.width_display = 0;
        state.width_floor = 0
    }else{
        state.shelf_depth = 0;
        state.depth_fract = 0;
        state.depth_display = 0
        state.depth_floor = 0
    }
}


