let validData = {
  config1_input_one:{
    low:21,
    high:360,
  },


  config2_input_one:{
    low:3,
    high:100,
  },
  config2_input_two:{
    low:4,
    high:89,
  },
  config2_input_three:{
    low:5.25,
    high:100,
  },

  config3_input_one:{
    low:5.25,
    high:100,
  },
  config3_input_two:{
    low:5,
    high:90,
  },

  config4_input_one:{
    low:3,
    high:100,
  },
  config4_input_two:{
    low:8,
    high:176,
  },
  config4_input_three:{
    low:1.75,
    high:100,
  },

  config5_input_one:{
    low:10,
    high:180,
  },
  config5_input_two:{
    low:1.75,
    high:100,
  },


  config6_input_one:{
    low:5.25,
    high:100,
  },
  config6_input_two:{
    low:5,
    high:90,
  },

  config7_input_one:{
    low:3,
    high:100,
  },
  config7_input_two:{
    low:3.5,
    high:100,
  },
  config7_input_three:{
    low:4,
    high:118,
  },

  config8_input_one:{
    low:4,
    high:100,
  },
  config8_input_two:{
    low:8,
    high:89,
  },

}
export const getValidatedData = (step) =>{
  return validData[step];
}

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

export const checkInputValue = (event,step) => {
  const depth = event.target.value;
  const formats = {
    integer: /^\d+$/,               // Matches "12"
    decimal: /^\d+\.\d+$/,          // Matches "12.5"
    fractionWithSpace: /^(\d+) (\d+)\/(\d+)$/, // Matches "12 1/2"
    fractionWithHyphen: /^(\d+)-(\d+)\/(\d+)$/  // Matches "12-1/2"
  };

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


function validateInterValue(data,step) {
  var valid = validData[step];
  if (data < valid.low) {
    return { 'error': `Value must be getter than or equal to ${valid.low}`,'value':valid }
  } else if (data > valid.high) {
    return { 'error': `Value must no be getter than ${valid.high}`,'value':valid }
  }
}

function validateFractionWithSpace(depth, data,step) {
  const [val, fract] = depth.split(" ");
  if (Object.values(fractional).indexOf(data.fract) == -1) {
    return { 'error': "Invailate Number" }
  }else {
    var valid = validData[step];
    if (data.val < valid.low) {
      return { 'error': `Value must be getter than or equal to ${valid.low}`,'value':valid }
    } else if (data.val > valid.high) {
      return { 'error': `Value must no be getter than ${valid.high}`,'value':valid }
    }
  }

}

function validateFractionWithHyphen(depth, data,step) {
  const [val, fract] = depth.split("-");
  if (Object.values(fractional).indexOf(data.fract) == -1) {
    return { 'error': "Invailate Number" }
  } else {
    var valid = validData[step];
    if (data.val < valid.low) {
      return { 'error': `Value must be getter than or equal to ${valid.low}`,'value':valid }
    } else if (data.val > valid.high) {
      return { 'error': `Value must no be getter than ${valid.high}`,'value':valid }
    }
  }
}
