export const totalInc = (state) => {
    let measurement = getMeasurement(state);
    let sumofmeasurement = 0;
    if (measurement) {
        measurement.map(function (data) {
            sumofmeasurement += calculateMeasurement(data.step, Number(data.val));
        });
        return Math.ceil(Number(sumofmeasurement ? sumofmeasurement : 0));
    }
    return Math.ceil(Number(sumofmeasurement));
};

export const inputedMeasurement = (state) => {
    return getMeasurement(state);
};

export const showOnlyProductList = (state) => {
    return !Object.hasOwn(state.products, 'key');
};
export const totalPrice = (state) => {
    return Number(state.qty) * Number(state.price);
};
export const totalQty = (state) => {
    return Number(state.qty);
};

function getMeasurement(state) {
    switch (state.configuration.id) {
        case 1:
            return [state.config1_input_one];
        case 2:
            return [state.config2_input_one, state.config2_input_two, state.config2_input_three];
        case 3:
            return [state.config3_input_one, state.config3_input_two];
        case 4:
            return [state.config4_input_one, state.config4_input_two, state.config4_input_three];
        case 5:
            return [state.config5_input_one, state.config5_input_two];
        case 6:
            return [state.config6_input_one, state.config6_input_two];
        case 7:
            return [state.config7_input_one, state.config7_input_two, state.config7_input_three];
        case 8:
            return [state.config8_input_one, state.config8_input_two];

        default:
            break;
    }
}

function calculateMeasurement(configType, val) {
    switch (configType) {
        case 'config1_input_one':
            return Number(val);

        case 'config2_input_one':
            // HEIGHT
            return (Number(val) - 0.5) * 2;
        case 'config2_input_two':
            // LENGTH
            return (Number(val) - 0.5) * 4;
        case 'config2_input_three':
            // WIDTH
            return Number(val) - 1;
        case 'config3_input_one':
            // WIDTH
            return Number(val) - 1;
        case 'config3_input_two':
            // LENGTH
            return (Number(val) - 0.5) * 4;

        case 'config4_input_one':
            // HEIGHT
            return (Number(val) - 0.5) * 2;
        case 'config4_input_two':
            // LENGTH
            return (Number(val) - 0.5) * 2;
        case 'config4_input_three':
            // WIDTH
            return Number(val) - 0.25;

        case 'config5_input_one':
            // LENGTH
            return (Number(val) - 0.5) * 2;
        case 'config5_input_two':
            // WIDTH
            return Number(val) - 0.25;

        case 'config6_input_one':
            // WIDTH
            return (Number(val) - 1) * 2;
        case 'config6_input_two':
            // LENGTH
            let formula_one = Number(val) - 0.5;
            let formula_two = Number(val) - 1.5;
            return formula_one + (formula_two * 3);

        case 'config7_input_one':
            // HEIGHT
            return (Number(val) - 0.5) * 2;
        case 'config7_input_two':
            // WIDTH
            return Number(val) - 1;
        case 'config7_input_three':
            // LENGTH
            let formula7_one = Number(val);
            let formula7_two = Number(val) - 0.5;
            return formula7_one + formula7_two * 2;

        case 'config8_input_one':
            return Number(val);

        case 'config8_input_two':
            // LENGTH
            return Number(val) * 3;

        default:
            break;
    }
}

export const completedSection = (state, getters) => {
    let { configuration, products, product, price } = state;
    let { totalPrice } = getters;
    let completedSteps = [];
    console.log(totalPrice);

    if (Object.keys(configuration).length > 0) {
        completedSteps.push(1);
    }

    if (products.length > 0 && Object.keys(product).length > 0) {
        completedSteps.push(2);
    }

    if (totalPrice > 0) {
        completedSteps.push(3);
    }
    return completedSteps;
};
