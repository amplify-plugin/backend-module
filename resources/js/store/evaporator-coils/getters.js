export const depth_fract = (state) => {
    return {
        'input-one':state.depth_display,
        'input-two':state.width_display
    }
}

export const validator = (state) =>{
    if(state.measurement.measurement_one > state.measurement.measurement_seven){
        return {
            'error':"The casing width value must be greater than the finned width value."
        };
    }
    if(state.measurement.measurement_three > state.measurement.measurement_six){
        return {
            'error':"The casing height value must be greater than the finned height value."
        };
    }
    return {
        "success":'success'
    };
}

export const completedSection = (state, getters) => {
    let {measurement,coils} = state;
    let completedSteps = [];

    if(measurement.measurement_one!=0 && measurement.measurement_two!=0 && measurement.measurement_three!=0 && measurement.measurement_four!=0 && measurement.measurement_five!=0 && measurement.measurement_six!=0 && measurement.measurement_seven!=0){
        completedSteps.push(1);
    }
    if(coils.coil_is_coated){
        completedSteps.push(2);
    }
    if(coils.copper_tube){
        completedSteps.push(3);
    }
    if(coils.number_of_fins_per_inc){
        completedSteps.push(4);
    }
    if(coils.number_of_tubes){
        completedSteps.push(5);
    }
    if(coils.qty){
        completedSteps.push(6);
    }

    if(coils.address && coils.city){
        completedSteps.push(7);
    }

    return completedSteps;
}