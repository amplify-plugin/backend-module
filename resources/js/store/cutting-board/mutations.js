import axios from 'axios'
import { generateProduct, getWireSelfPrice } from "../helper"
import Api from "../apis";

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

export const SET_THICKNESS = (state, depth) => {
    state.thickness = depth
}


export const SET_PRODUCTS = (state,products) => {
    state.products = products
}
export const SET_PRICE = (state) => {
    if(state.thickness){
        let product = state.products.filter(function (product) {
            let productKey = Object.keys(product);
            return productKey == state.thickness;
        });
        let code = Object.values(product[0]);
        state.product = code
        getFullPageLoader();
        Api.get(`/custom-item/cutting-board/product-price/${code}`).then((res) => {
            if(!res.data.Price){
                ShowNotification('error', 'Order', 'Selling price not found!');
                state.selling_price = 0;
            }else{
                state.selling_price = res.data.Price;
            }
            removeFullPageLoader();
        })
            .catch((err) => {
                removeFullPageLoader();
                ShowNotification('error', 'Order', err.response);
            });
    }else{
        ShowNotification('error', 'Order','Please specify the desired thickness first!');
        removeFullPageLoader();
    }
}

export const SET_QTY = (state,qty) => {
    state.qty = qty
}

