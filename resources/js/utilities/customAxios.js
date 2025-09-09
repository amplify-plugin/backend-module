import axios from 'axios';
let base_url = (typeof AMPLIFY_BASE_URL  != 'undefined') ? AMPLIFY_BASE_URL  : '';
const customAxios = axios.create({
  baseURL:`${base_url}/api`,
  headers: {
    'Content-Type': 'application/json',
    //  withCredentials: true
  }
});

export default customAxios;