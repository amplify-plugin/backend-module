import axios from 'axios'
import customAxios from '../../utilities/customAxios'
export const GASKET_STYLE = (state, data) => {
    state.gasket_style = data
}

export const PRODUCTS = (state, data) => {
    state.profileProducts = {}
    data.pop()
    customAxios.post("/custom-item/gasket/products",{"product":data}).then((res) => {
        state.stepOneProducts = res.data.data
    })
        .catch((err) => {
            console.log(err)
            ShowNotification('error', 'Order', err.response.data.error);
        })
}

export const PRODUCTS_PROFILE = (state, data) => {
    customAxios.post("/custom-item/gasket/profiles",{"product":data}).then((res) => {
        state.profileProducts = res.data.data
    })
        .catch((err) => {
            console.log(err)
            ShowNotification('error', 'Order', err.response.data.error);
        })
}

export const SET_PROFILE_PRODUCTS = (state, data) => {
    state.singleProfileProducts = data
    state.productPrice = data.price
}
export const SET_PRODUCTS_PRICE = (state, data) => {
    state.productPrice = data?.OrderPrice
}

export const SET_NUMBER_OF_SIDE = (state, data) => {
    state.productSide = data
}

export const SET_MEASUREMENT = (state, data) => {
    if(data.step == "input-one"){
        state.depth = data.val
        state.depth_display = data.dispaly
    }else{
        state.width = data.val
        state.width_display = data.dispaly
    }
}

export const SET_QUANTITY = (state, qty) => {
    state.qty = qty
}

export const SET_FOAM_FILL = (state, foam) => {
    state.foam_fill = foam
}

export const SET_DOOR_HINGED = (state, hinged) => {
    state.door_hinged = hinged
}
export const SELECTED_STEP = (state, stype) => {
    state.selected_type = stype
}