import { sweetAlertToaster, sweetAlertToasterForCoils } from "../../modules/custom-item/helper";
import customAxios from "../../utilities/customAxios";

export const setMeasurement = ({ commit }, params) => {
    commit('setMeasurement', params);
}

export const setCoilValue = ({ commit }, params) => {
    commit('setCoilValue', params);
}
export const resetValidator = ({ commit }) => {
    commit('resetValidator');
}

export const getCountryStateList = ({ commit }) => {
    customAxios.get('/custom-item/evaporator-coils/country-list').then((res) => {
        commit('setCountries', res.data.countries);
        commit('setStates', res.data.states);
    })
        .catch((err) => {
            ShowNotification('error', 'Order', err.response.data.error);
        })
}
export const submitEvaporatorCoils = ({ commit,state },swal) => {
    const data = {
        address:state.coils.address,
        coil_is_coated:state.coils.coil_is_coated,
        copper_tube:state.coils.copper_tube,
        number_of_fins_per_inc:state.coils.number_of_fins_per_inc,
        number_of_tubes:state.coils.number_of_tubes,
        qty:state.coils.qty,

        contact_name:state.coils.contact_name,
        method_of_contact:state.coils.method_of_contact,
        company_name:state.coils.company_name,
        address:state.coils.address,
        city:state.coils.city,
        country:state.coils.country?.name,
        state:state.coils.state?.name,
        zipcode:state.coils.zipcode,
        note:state.coils.note,

        measurement_one_display:state.measurement.measurement_one_display,
        measurement_two_display:state.measurement.measurement_two_display,
        measurement_three_display:state.measurement.measurement_three_display,
        measurement_four_display:state.measurement.measurement_four_display,
        measurement_five_display:state.measurement.measurement_five_display,
        measurement_six_display:state.measurement.measurement_six_display,
        measurement_seven_display:state.measurement.measurement_seven_display,
    }
    customAxios.post('/custom-item/evaporator-coils/store',data).then((res) => {
        sweetAlertToasterForCoils(swal);
    })
        .catch((err) => {
            console.log(err)
            ShowNotification('error', 'Order', err.response.data.message);
        })
}
