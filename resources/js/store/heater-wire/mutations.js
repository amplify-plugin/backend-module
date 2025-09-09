import { calculateTotalFeet } from "../helper";

export const setPrice = (state, price) => {
    state.wireStepOneWire = true;
    state.productPrice = price;
    state.productPrice > 1 ? state.wireStepTwo = true : state.wireStepOneWire = true;
}

export const setInches = (state, inches) => {
    state.msg = '';
    if (inches > state.max_inches && parseInt(inches) > 0) {
        state.msg = "Please enter a value between 0 and 400!"
    } else {
        let incTofeet = inches / 12;
        let totalFeet = Math.ceil(incTofeet);
        state.inches = inches;
        state.incToFeet = totalFeet;
        calculateTotalFeet(state);
        inches > 0 ? state.wireStepFive = true : state.wireStepFive;
    }

}

export const setQty = (state, qty) => {
    state.qty = qty;
    calculateTotalFeet(state);
    qty > 0 ? state.completedStep = true : state.completedStep = false
}

export const setVoltage = (state, voltage) => {
    state.voltage = voltage
    voltage ? state.wireStepThree = true : state.wireStepThree = false;
}

export const setHoldingTemp = (state, temp) => {
    state.temp = temp
    temp ? state.wireStepFour = true : state.wireStepFour = false;
}

export const setWraps = (state, wraps) => {
    state.wraps = wraps
    wraps ? state.wireStepSix = true : state.wireStepSix = false;
}

export const setProduct = (state, product) => {
    state.product = product
}
export const setProducts = (state, product) => {
    state.products = product
}
