export const dispalyVal = (state) => {
    return {
        'input-one':state.depth_display,
        'input-two':state.width_display
    }
}
export const totalSquareInches= (state) => {
        return Number(state.shelf_depth) * Number(state.shelf_width)
}
export const totalSquareInchesWithQty= (state) => {
    if(state.qty){
        let squareInc = Number(state.shelf_depth) * Number(state.shelf_width)
        return Number(squareInc) * Number(state.qty);
    }
        return 0;
}

export const totalPrice= (state) => {
    let squareInc = Number(state.shelf_depth) * Number(state.shelf_width)
    let totalSquareInc =Number(squareInc) * Number(state.qty);
    let total =Number(totalSquareInc) * Number(state.selling_price);
    return total.toFixed(2);
}

export const completedSection= (state,getters) => {
    let {shelf_depth,shelf_width , thickness,selling_price, qty, } = state;
    let {totalPrice} = getters;
    let completedSteps = [];

    if(shelf_depth && shelf_width){
        completedSteps.push(1);
    }
    if(thickness && selling_price){
        completedSteps.push(2);
    }
    if(totalPrice && totalPrice > 0){
        completedSteps.push(3);
    }
    return completedSteps;
}
