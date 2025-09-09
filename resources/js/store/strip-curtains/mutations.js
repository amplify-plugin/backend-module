import Api from "../apis";
export const setStrips = (state, product) => {
    state.replacementProduct = product;
}
export const setCurtains = (state, data) => {
    state.replacementStripLengthInc = 0;
    state.replacementStripQty = 0;
    state.selectedCurtains = data
}
export const setCurtainArea = (state, item) => {
    if (item) {
        state.curtainArea = item
    } else {
        state.curtainArea = ''
    }
}

export const setProducts = (state, products) => {
    state.replacementProducts = products
}
export const getReplacementProductPrice = (state, product) => {
    let curtain = state.selectedCurtains;
    let replaceProduct = `${state.selectedCurtains.type} ${state.curtainArea}`
    if (state.curtainArea) {
        let product = state.replacementProducts.filter(function (product) {
            let productKey = Object.keys(product);
            return replaceProduct == productKey[0];
        })
        let code = Object.values(product)[0][replaceProduct];
        state.replacementProductCode = code;
        getFullPageLoader();
        Api.get(`/custom-item/strip-replacement/product-price/${code}`).then((res) => {
            if(!res.data.Price){
                ShowNotification('error', 'Order', 'Selling price not found!');
                state.replacementProductPrice = 0;
            }else{
                state.replacementProductPrice = res.data.Price;
            }
            removeFullPageLoader();
        })
            .catch((err) => {
                removeFullPageLoader();
                ShowNotification('error', 'Order', err.response);
            });
    }

}

export const setStripLength =(state, length) => {
    state.replacementStripLengthInc = length
    state.replacementStripLengthFeet = Math.ceil(length/12);
}

export const setQty =(state, qty) => {
    state.replacementStripQty = qty
}

export const stripLengthValidation =(state,msg) => {
    state.stripLengthValidationMsg = msg
}

export const setStripType = (state,val) =>{
    state.stripReplacementType = val
}

