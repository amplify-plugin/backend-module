import Api from "../index";

export default{

    getProductByCode(code){
       return Api.get(`/product/price?code=${code}`)
    },

    addToCart(data){
        return Api.post('/custom-item/add-to-cart',data);
    }

}
 