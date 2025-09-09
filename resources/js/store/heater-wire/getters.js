export const completedSection= (state) => {
    let {productPrice,voltage,temp,incToFeet,wraps,totalPrice} = state;
    let completedSteps = [];

    if(productPrice > 0){
        completedSteps.push(1);
    }
    if(voltage){
        completedSteps.push(2);
    }
    if(temp){
        completedSteps.push(3);
    }
    if(incToFeet > 0){
        completedSteps.push(4);
    }
    if(wraps){
        completedSteps.push(5);
    }
    if(totalPrice > 0){
        completedSteps.push(6);
    }
   
    return completedSteps;
}
