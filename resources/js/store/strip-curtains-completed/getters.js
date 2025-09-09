export const totalCurrentPrice = (state) => {
    let totalInc = state.depth * state.height;
    let price = state.productPrice * totalInc;
    return price.toFixed(2);
}
export const totalSquareInc = (state) => {
    return state.depth * state.height * state.quantity;
}

export const totalPrice = (state) => {
    let totalInc = state.depth * state.height;
    let price = state.productPrice * totalInc;
    let totalPrice =Number(price) * Number(state.quantity);
    return totalPrice.toFixed(2)
}

export const completedSection= (state,getters) => {
    let {curtainArea,stripWidth , product, depth, height, is_mounting_bar, quantity } = state;
    let {totalPrice,totalCurrentPrice} = getters;
    let completedSteps = [];

    if(curtainArea){
        completedSteps.push(1);
    }
    if(totalCurrentPrice > 0){
        completedSteps.push(2);
    }
    if(is_mounting_bar){
        completedSteps.push(3);
    }
    if(quantity && totalPrice){
        completedSteps.push(4);
    }
    return completedSteps;
}