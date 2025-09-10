export const depth_fract = (state) => {
    return {
        'input-one': state.depth_display,
        'input-two': state.width_display
    }
}

export const totalFeet = (state) => {
    return getTotalFeet(state);
}

export const totalQty = (state) => {
    let totalFeet = getTotalFeet(state);
    return state.qty * totalFeet
}

export const totalPrice = (state) => {
    let totalFeet = getTotalFeet(state);
    let totalQty = state.qty * totalFeet;
    let totalPrice = state.productPrice * totalQty
    return totalPrice.toFixed(2);
}

export const checkPrice = (state) => {
    return Number(state.productPrice) > 0
}

export const completedSection= (state,getters) => {
    let {selected_type,productPrice, productSide, depth_display,width_display,foam_fill} = state;
    let {totalPrice,totalFeet} = getters;
    let completedSteps = [];

    // completedSteps.push(1);
    if(selected_type == "profile"){
        completedSteps.push(2);
    }
    if(productPrice > 0){
        completedSteps.push(3);
    }
    if(productSide){
        completedSteps.push(4);
    }
    if(depth_display && width_display && totalFeet){
        completedSteps.push(5);
    }
    if(foam_fill){
        completedSteps.push(6);
    }
    if(totalPrice > 0){
        completedSteps.push(7);
    }
    return completedSteps;
}

function getTotalFeet(state) {
    if (state.productSide == 3) {
        let inches = Number(state.width) + Number(state.width) + Number(state.depth);
        let feet = inches / 12;
        let totalFeet = Math.ceil(feet);
        return totalFeet;
    } else {
        let inches = (Number(state.depth) + Number(state.depth))+ (Number(state.width) + Number(state.width));
        let feet = inches / 12;
        let totalFeet = Math.ceil(feet);
        return totalFeet;
    }
}
