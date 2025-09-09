export const depth_fract = (state) => {
    return {
        'input-one': state.depth_display,
        'input-two': state.width_display,
    };
};

export const shippingMethodVia = (state) => {
    if (state.shippingVia) {
        return state.shippingVia;
    } else {
        return state.methods.FreightRate ? Object.keys(state.methods.FreightRate)[0] : '';
    }
};

export const shippingMethods = (state) => {
    return state.methods?.FreightRate ?? {};
};
