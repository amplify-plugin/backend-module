export const totalFeet = (state) => {
    return state.replacementStripLengthFeet * state.replacementStripQty;
}
export const totalPrice = (state) => {
    let feet = state.replacementStripLengthFeet * state.replacementStripQty;
    let price = state.replacementProductPrice * feet;
    return price.toFixed(2);
}

export const completedSection= (state,getters) => {
    let {selectedCurtains, curtainArea,replacementProductPrice,replacementStripLengthInc} = state;
    let {totalPrice} = getters;
    let completedSteps = [];

    if(selectedCurtains){
        completedSteps.push(1);
    }

    if(curtainArea && replacementProductPrice >0){
        completedSteps.push(2);
    }

    if(replacementStripLengthInc){
        completedSteps.push(3);
    }

    if(totalPrice > 0){
        completedSteps.push(4);
    }
    
    return completedSteps;
}



