import Api from "../apis";

export const SET_MEASUREMENT = (state, data) => {
    let { selectedItem, event } = data;
    let val = event.target.value;
    if (selectedItem && selectedItem == 'depth') {
        state.depth = val
    }
    if (selectedItem && selectedItem == 'height') {
        state.height = val
    }
}

export const SET_STRIP_WIDTH = (state, val) => {
    state.stripWidth = val
    state.depth = 0
    state.height = 0
}

export const SET_MESSAGE_BOX = (state, status) => {
    state.errorMsgBox = status
}

export const SET_CURTAIN_AREA = (state, data) => {
    state.curtainArea = data
}

export const SET_PRICE = (state) => {
    
    if (state.curtainArea && state.stripWidth) {
        getFullPageLoader();
        let product = state.curtainArea + state.stripWidth;
        state.product = product;
        Api.get(`/custom-item/strip-curtains/completed/product-price/${product}`).then((res) => {

            if(!res.data.Price){
                ShowNotification('error', 'Order', 'Selling price not found!');
                state.productPrice = 0;
            }else{
                state.productPrice = res.data.Price;
            }
            removeFullPageLoader();
        })
            .catch((err) => {
                removeFullPageLoader();
                ShowNotification('error', 'Order', JSON.stringify(err.response));
            });
    }
}

export const SET_MOUNTING_BAR = (state, data) => {
    state.is_mounting_bar = data
}
export const SET_QUANTITY = (state,data) => {
    state.quantity = data
}