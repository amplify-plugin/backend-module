import axios from 'axios'
import { generateProduct, getWireSelfPrice } from "../helper"

export const setMeasurement = (state, param) => {
    if(param.step =='input-one'){
        state.measurement.measurement_one = Math.ceil(param.val)
        state.measurement.measurement_one_display = param.dispaly
    }
    if(param.step =='input-two'){
        state.measurement.measurement_two = Math.ceil(param.val)
        state.measurement.measurement_two_display = param.dispaly
    }
    if(param.step =='input-three'){
        state.measurement.measurement_three = Math.ceil(param.val)
        state.measurement.measurement_three_display = param.dispaly
    }

    if(param.step =='input-four'){
        state.measurement.measurement_four = Math.ceil(param.val)
        state.measurement.measurement_four_display = param.dispaly
    }

    if(param.step =='input-five'){
        state.measurement.measurement_five = Math.ceil(param.val)
        state.measurement.measurement_five_display = param.dispaly
    }

    if(param.step =='input-six'){
        state.measurement.measurement_six = Math.ceil(param.val)
        state.measurement.measurement_six_display = param.dispaly
    }
    if(param.step =='input-seven'){
        state.measurement.measurement_seven = Math.ceil(param.val)
        state.measurement.measurement_seven_display = param.dispaly
    }
}
export const setCoilValue = (state, param) => {
    state.coils = param
}
export const setCountries = (state, countries) => {
    state.countries = countries
}

export const setStates = (state, states) => {
    state.states = states
}
export const resetValidator = (state) => {
    state.resetValidator = {}
}