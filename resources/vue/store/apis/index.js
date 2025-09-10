import axios from 'axios'
let base_url = (typeof AMPLIFY_BASE_URL  != 'undefined') ? AMPLIFY_BASE_URL  : '';
const Api =axios.create({
    baseURL:`${base_url}/api`
});
export default Api;