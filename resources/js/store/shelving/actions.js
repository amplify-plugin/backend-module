import Api from "../apis";
import { generateProduct , getWireSelfPrice} from "../helper";
import { sweetAlertToaster } from '../../modules/custom-item/helper';
import customAxios from "../../utilities/customAxios";

export const getDepth = ({ commit }, params) => {
    commit('setDepth', params);
    commit('setPrice');
}
export const getDepthFract = ({ commit }, params) => {
    commit('setDepthFract', params);
    commit('setPrice');
}

export const getDiameter = ({commit},event) => {
    let diameter = event.target.value;
    commit('setDiameter',diameter);
    commit('setPrice');
}

export const getFinishandPrice = ({commit,state},event) => {
    
    let finish = event.target.value;
    commit('setFinish',finish);
    commit('setPrice');
}

export const getQuantity = ({commit},event) => {
    let qty = Number.isInteger(event)?event:event.target.value;
    commit('setQty',qty);
}


export const cancelModal = ({commit} , data) => {
    commit('removeData',data);
}

export const addToCart = ({state, commit ,getters}, swal) => {
    let depth           = state.shelf_depth;
    let width          = state.shelf_width;
    let totalPrice           = getters.totalPrice; 
    let qty                  = state.qty;
    let depthDisplay                = state.depth_display;
    let widthDisplay               = state.width_display;
    let diameter             = state.diameter;
    let finish               = state.finish;
    let product              = state.product;
    let price                = getters.price
    const [width_floor,width_fract] = depthDisplay.split('-');
    const [depth_floor,depth_fract] = widthDisplay.split('-');

    let OrderSpec    = `${qty}EA, ${width_floor} ${width_fract !=undefined ?width_fract:''}W X ${depth_floor} ${depth_fract !=undefined ?depth_fract:''}D, ${diameter}, ${finish}`;


    const formData = new FormData();
    formData.append('depth',depth);
    formData.append('width',width);
    formData.append('depthDisplay',depthDisplay);
    formData.append('widthDisplay',widthDisplay);
    formData.append('diameter',diameter);
    formData.append('finish',finish);
    formData.append('price',price);
    formData.append('qty',qty);
    formData.append('totalPrice',totalPrice.toFixed(2));
    formData.append('product',product);
    formData.append('OrderSpec',OrderSpec);

    getFullPageLoader();
    customAxios.post('/custom-item/shelving/add-to-cart',formData).then((res)=>{
        removeFullPageLoader();
        sweetAlertToaster(swal,res.data.cart_summary,res.data.shop);
    })
    .catch((err)=>{
        removeFullPageLoader();
        ShowNotification('error', 'Order', err.response.data.error);
    });
    // commit('setWraps',wraps ?? 0)
}
