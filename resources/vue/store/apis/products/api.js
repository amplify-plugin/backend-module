import Api from "../index";

export default{
    getProductByCode(code){
       return Api.get(`/product/price?code=${code}`)
    },

    getShelvingProductPrice(data){
        return Api.post('api/shelving/product/price',data);
     }
}
 