let fractional = {
  0: '0/8', 0.125: '1/8', 0.25: '1/4', 0.375: '3/8', 0.5: '1/2', 0.625: '5/8', 0.75: '3/4', 0.875: '7/8'
};

// let stepOne = {
//   'input-one':{low:4,high:24},
//   'input-two': {low:4,high:12},
//   'input-three': {low:4,high:360},
//   'input-four': {low:0,high:5},
//   'input-five': {low:0,high:5},
//   'input-six': {low:0,high:16},
//   'input-seven': {low:0,high:30},
// }

let stepOne = {
  'input-one':{low:4,high:24},
  'input-three': {low:4,high:12},
  'input-five': {low:4,high:360},
  'input-four': {low:0,high:5},
  'input-six': {low:0,high:30},
  'input-seven': {low:0,high:30},
  'input-two': {low:0,high:5},
}

function getFaction() {
  return [
    { key: 0.125, value: "1/8" },
    { key: 0.25, value: "1/4" },
    { key: 0.375, value: "3/8" },
    { key: 0.50, value: "1/2" },
    { key: 0.625, value: "5/8" },
    { key: 0.75, value: "3/4" },
    { key: 0.875, value: "7/8" },
  ];
}

export const checkInputValue = (event,step,state) => {
  
  var depth = Number(event.target.value);

  const formats = {
    integer: /^\d+$/,               // Matches "12"
    decimal: /^\d+\.\d+$/,          // Matches "12.5"
    fractionWithSpace: /^(\d+) (\d+)\/(\d+)$/, // Matches "12 1/2"
    fractionWithHyphen: /^(\d+)-(\d+)\/(\d+)$/  // Matches "12-1/2"
  };
  
  if(depth == 0){
    return { 'display': '', 'val': '', 'fract': '' }
  }
  if (formats.integer.test(depth)) {
    return validateInterValue(depth,step) ?? getInteger(depth);
  } else if (formats.decimal.test(depth)) {
    return validateInterValue(depth,step) ?? getDecimal(depth);
  } else if (formats.fractionWithSpace.test(depth)) {
    let data = getFractionWithSpace(depth);
    return validateFractionWithSpace(depth, data,step) ?? data;
  } else if (formats.fractionWithHyphen.test(depth)) {
    let data = getFractionWithHyphen(depth);
    return validateFractionWithHyphen(depth, data, step) ?? data;
  } else {
    return getInvalidMessage();
  }
}

function getFractionWithHyphen(depth) {
  const [val, fract] = depth.split("-");
  const [up, down] = fract.split("/");
  let fractNumber = Number(up) / Number(down);
  let number = Number(val) + Number(fractNumber);
  return { 'display': `${val}-${fract}`, 'val': number, 'fract': fract }
}

function getFractionWithSpace(depth) {
  const [val, fract] = depth.split(" ");
  const [up, down] = fract.split("/");
  let fractNumber = Number(up) / Number(down);
  let number = Number(val) + Number(fractNumber);
  return { 'display': `${val}-${fract}`, 'val': number, 'fract': fract }
}

function getDecimal(depth) {
  var decimalPart = Math.abs(depth) - Math.floor(Math.abs(depth));
  let decimal = decimalPart.toFixed(4);
  let floor = Math.floor(depth);
  let data = getFaction();
  for (let index = 0; index < data.length; index++) {
    const element = data[index];
    let key = element.key;
    let value = element.value;
    if (Number(decimal) && Number(decimal) <= Number(key)) {
      return { 'display': `${floor}-${value}`, 'val': depth }
    } else if (Number(decimal) > 0.875) {
      let ceil = Math.ceil(depth);
      return { 'display': `${ceil}-0/8`, 'val': depth }
    }
  }
}

function getInteger(depth) {
  return { 'display': `${depth}`, 'val': depth }
}

function getInvalidMessage() {
  return { 'error': "Oops! It seems like you've entered an incorrect value. Please enter a valid number in the input field." }
}

function finnedValidator(val) {

}


function validateInterValue(data,step) {
  if (data < stepOne[step].low) {
    return { 'error': "Value must be getter than or equal to 6" }
  } else if (data > stepOne[step].high) {
    return { 'error': "Value must no be getter than 48" }
  }
}

function validateFractionWithSpace(depth, data, step) {
  const [val, fract] = depth.split(" ");
  if (Object.values(fractional).indexOf(data.fract) == -1) {
    return { 'error': "Invailate Number" }
  }else {
    if (val < stepOne[step].low) {
      return { 'error': "Value must be getter than or equal to 6" }
    } else if (val > stepOne[step].high) {
      return { 'error': "Value must no be getter than 48" }
    }
  }
}

function validateFractionWithHyphen(depth, data, step) {
  const [val, fract] = depth.split("-");
  if (Object.values(fractional).indexOf(data.fract) == -1) {
    return { 'error': "Invailate Number" }
  } else {
    if (val < stepOne[step].low) {
      return { 'error': "Value must be getter than or equal to 6" }
    } else if (val > stepOne[step].high) {
      return { 'error': "Value must no be getter than 48" }
    }
  }
}


export const sweetAlertToaster = (swal,cart_summary,shop) => {
  swal({
    title: 'THANK YOU!',
    text: "Your custom item has been added to your cart.",
    type: 'warning',
    showCancelButton: false,
    showDenyButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#303190',
    confirmButtonText: 'Continue Shopping',
    denyButtonText: "Cart",
  }).then((result) => {
    if (result.value) {
      window.location.reload();
    } else if (result.isDenied) {
      window.location.href =cart_summary
    } else {
      window.location.reload();
    }
  });
}

export const getStepValue = (step)=> {
  return stepOne[step];
} 