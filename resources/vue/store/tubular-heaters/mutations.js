export const SET_CONFIGURATION = (state, val) => {
    state.configuration = val
}
export const GET_PRODUCTS = (state, val) => {
    state.products = val
}
export const SET_PRODUCT = (state, product) => {
    state.product = product
}
export const CHANGE_PRODUCT = (state) => {
    state.product = {}
}
export const SET_PRODUCT_PRICE = (state,price) => {
    state.price = price
}
export const SET_QUANTITY = (state,qty) => {
    state.qty = qty
}

export const GET_ROLL = (state,val) =>{
    state.roll = val
    
}
export const SET_MEASUREMENT = (state, val) => {
    state.price = 0
    switch (val.step) {
        case "config1_input_one":
            state.config_length_val = val
            state.config1_input_one = val
            break;

        case "config2_input_one":
            state.config2_input_one = val
            break;
        case "config2_input_two":
            state.config_length_val = val
            state.config2_input_two = val
            break;
        case "config2_input_three":
            state.config2_input_three = val
            break;

        case "config3_input_one":
            state.config3_input_one = val
            break;
        case "config3_input_two":
            state.config_length_val = val
            state.config3_input_two = val
            break;

        case "config4_input_one":
            state.config4_input_one = val
            break;
        case "config4_input_two":
            state.config_length_val = val
            state.config4_input_two = val
            break;
        case "config4_input_three":
            state.config4_input_three = val
            break;

        case "config5_input_one":
            state.config_length_val = val
            state.config5_input_one = val
            break;
        case "config5_input_two":
            state.config5_input_two = val
            break;

        case "config6_input_one":
            state.config6_input_one = val
            break;
        case "config6_input_two":
            state.config_length_val = val
            state.config6_input_two = val
            break;

        case "config7_input_one":
            state.config7_input_one = val
            break;
        case "config7_input_two":
            state.config7_input_two = val
            break;
        case "config7_input_three":
            state.config_length_val = val
            state.config7_input_three = val
            break;

        case "config8_input_one":
            state.config8_input_one = val
            break;
        case "config8_input_two":
            state.config_length_val = val
            state.config8_input_two = val
            break;
        default:
            break;
    }


}
