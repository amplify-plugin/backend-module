/* 
  =====================================================================================================================
*/

let fractional = {
  0: '0/8', 0.125: '1/8', 0.25: '1/4', 0.375: '3/8', 0.5: '1/2', 0.625: '5/8', 0.75: '3/4', 0.875: '7/8'
};

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

export const checkInputValue = (event) => {
  const depth = Number(event.target.value);
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
    return validateInterValue(depth) ?? getInteger(depth);
  } else if (formats.decimal.test(depth)) {
    return validateInterValue(depth) ?? getDecimal(depth);
  } else if (formats.fractionWithSpace.test(depth)) {
    let data = getFractionWithSpace(depth);
    return validateFractionWithSpace(depth, data) ?? data;
  } else if (formats.fractionWithHyphen.test(depth)) {
    let data = getFractionWithHyphen(depth);
    console.log(validateFractionWithHyphen(depth, data));
    return validateFractionWithHyphen(depth, data) ?? data;
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


function validateInterValue(data) {
  if (data < 6) {
    return { 'error': "Value must be getter than or equal to 6" }
  } else if (data > 95) {
    return { 'error': "Value must no be getter than 48" }
  }
}

function validateFractionWithSpace(depth, data) {
  const [val, fract] = depth.split(" ");
  if (Object.values(fractional).indexOf(data.fract) == -1) {
    return { 'error': "Invailate Number" }
  }else {
    if (val < 6) {
      return { 'error': "Value must be getter than or equal to 6" }
    } else if (val > 95) {
      return { 'error': "Value must no be getter than 48" }
    }
  }
}

function validateFractionWithHyphen(depth, data) {
  const [val, fract] = depth.split("-");
  if (Object.values(fractional).indexOf(data.fract) == -1) {
    return { 'error': "Invailate Number" }
  } else {
    if (val < 6) {
      return { 'error': "Value must be getter than or equal to 6" }
    } else if (val > 95) {
      return { 'error': "Value must no be getter than 48" }
    }
  }
}
