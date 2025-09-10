import { sweetAlertToaster } from '../../modules/custom-item/helper';
import customAxios from '../../utilities/customAxios';

export const getDepth = ({ commit, state }, params) => {
    commit('setDepth', params);
}

export const getProducts = ({ commit }) => {
    getFullPageLoader();
    customAxios.get('/custom-item/cutting-board/products').then((res) => {
        let item = JSON.parse(res.data);
        commit('SET_PRODUCTS',item.products);
        removeFullPageLoader();
    })
        .catch((err) => {
            ShowNotification('error', 'Order', err.response.data.error);
            removeFullPageLoader();
        })
}
export const getDepthFract = ({ commit }, params) => {
    commit('setDepthFract', params);
}

export const setThickness = ({ commit }, event) => {
    let thickness = event.target.value;
    commit('SET_THICKNESS', thickness);
    commit('SET_PRICE');
}

export const setQty = ({commit},event) => {
    let qty = Number.isInteger(event)?event:event.target.value;
    commit('SET_QTY',qty);
}
export const setPuzzleCut = ({commit},puzzle_cut) => {
    commit('SET_PUZZLE_CUT',puzzle_cut);
}

export const addToCart = ({state, commit ,getters}, swal) => {
    let length = state.shelf_length;
    let width = state.shelf_width;
    let selling_price = state.selling_price;
    let qty = state.qty;
    let thickness = state.thickness;
    let product = state.product;
    let totalSquareInches = getters.totalSquareInches;
    let totalPrice = getters.totalPrice;
    let puzzleCut = '';
    const [width_floor,width_fract] = state.width_display.split('-');
    const [length_floor,length_fract] = state.length_display.split('-');

    if (length_floor >= 48){
        puzzleCut = state.puzzle_cut=='yes' ? ', Y' : ', N';
    }

    let OrderSpec = `${qty}EA, ${width_floor} ${width_fract !=undefined?width_fract:''}W X ${length_floor} ${length_fract!==undefined?length_fract:''}L${puzzleCut}`;

    const formData = new FormData();
    formData.append('length',length);
    formData.append('width',width);
    formData.append('selling_price',selling_price);
    formData.append('qty',qty);
    formData.append('thickness',thickness);
    formData.append('product',product);
    formData.append('totalSquareInches',totalSquareInches);
    formData.append('totalPrice',totalPrice);
    formData.append('OrderSpec',OrderSpec);
    customAxios.post('/custom-item/cutting-board/add-to-cart',formData).then((res)=>{
        sweetAlertToaster(swal,res.data.cart_summary,res.data.shop);

    })
    .catch((err)=>{
        console.log(err)
        ShowNotification('error', 'Order', err.response.data.error);

    });

}

