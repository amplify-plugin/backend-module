export const depth_fract = (state) => {
    return {
        'input-one':state.depth_display,
        'input-two':state.width_display
    }
}

export const totalPrice = (state) => {
    let price = state.price;
    let depth = Number(state.shelf_depth);
    let width = Number(state.shelf_width);
    let qty   = Number(state.qty);
    let original_price = state.original_price;
    let minimum_price = state.minimum_price;
    let original = original_price * (depth * width) * qty;
    if(original > minimum_price){
        return original
    }else{
        return Number(minimum_price) * qty; 
    }
}

export const price = (state) =>{
    let depth = Number(state.shelf_depth);
    let width = Number(state.shelf_width);
    let original_price = state.original_price;
    let minimum_price = state.minimum_price;
    let qty   = Number(state.qty);
    let original = original_price * (depth * width) * qty;
    
    if(original > minimum_price){
        return Number(original_price);
    }else{
        return Number(minimum_price / (depth * width)); 
    }
}

export const firstStep = (state) => {
    return state.shelf_depth && state.shelf_width;
}

export const stepTwo = (state) => {
    return state.diameter;
}

export const stepThree = (state) => {
    return state.finish;
}

export const stepFour = (state) => {
    return state.qty;
}

export const activeButton = (state) => {
    if(state.qty && state.finish && state.diameter && state.shelf_depth &&  state.shelf_width){
        return true
    }
    return false
}

export const completedSection = (state, getters) => {
    let {shelf_depth,shelf_width,diameter,finish,original_price,qty} = state;
    let {totalPrice} = getters;
    let completedSteps = [];

    if(shelf_depth && shelf_width){
        completedSteps.push(1);
    }

    if(diameter){
        completedSteps.push(2);
    }

    if(finish && original_price){
        completedSteps.push(3);
    }

    if(qty && totalPrice){
        completedSteps.push(4);
    }
    return completedSteps;
}

