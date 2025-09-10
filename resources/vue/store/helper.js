
import Api from './apis/products/api'
export const calculateTotalFeet = (state) => {
    let qty = state.qty;
    let feet = state.incToFeet;
    if (qty > 0 && feet > 0) {
        let totalFeet = Number(feet) * Number(qty);
        let price = state.productPrice;
        state.totalFeet = totalFeet;
        state.totalPrice = Number(totalFeet) * Number(price)
    } else {
        state.totalFeet = 0;
    }
}

export const generateProduct = (state) => {
    let depth = Number(state.shelf_depth);
    let width = Number(state.shelf_width);
    let tier = Number(depth * width);
    let finish = state.finish;
    let diameter = state.diameter;
    let tierType = '';

    if (tier <= state.t1) {
        tierType = 'T1';
    }
    else if (tier => state.t1 && tier <= state.t2) {
        tierType = 'T2';
    }
    else if (tier => state.t2) {
        tierType = 'T3';
    }
    if (tierType) {
        return `${finish}-${diameter}${tierType}`;
    }

}

export const getWireSelfPrice = (formData) => {
    Api.getShelvingProductPrice(formData)
}

export const toster = (msg) => {
    this.$swal({
        toast: true,
        position: 'top-end', // toaster position
        showConfirmButton: false, // hide confirmation button
        timer: 3000, // auto-close after 3 seconds
        timerProgressBar: true, // show progress bar
        title: 'Hello Vue world!!!',
        onOpen: (toast) => {
            // add custom styling or animations to the toast
            toast.addEventListener('mouseenter', () => {
                toast.classList.add('hovered'); // add hover effect
            });
        },
        onClose: (toast) => {
            // perform actions on toast close
            toast.removeEventListener('mouseenter', () => { }); // remove hover effect
        }
    });
}