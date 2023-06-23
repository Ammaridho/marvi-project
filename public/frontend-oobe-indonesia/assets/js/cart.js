function storeCart(merchantId,productId,qty,weight,totalWeight,variant,attribute,extraAttribute,note,
    totalPricePerProduct,totalPriceAll,nameCart,cartId=null) {

    cart = JSON.parse(sessionStorage.getItem(nameCart));

    // if cart empty
    if (cart == null || cart.length == 0 || cart[0]['idMerchant'] != merchantId) {
        var cart = [];
    }

    if (cartId == null) {
        cart.push({ 
            'idMerchant'            : merchantId,
            'idProduct'             : productId,
            'qty'                   : qty,
            'weight'                : weight,
            'totalWeight'           : totalWeight,
            'variant'               : variant,
            'attribute'             : attribute,
            'extraAttribute'        : extraAttribute,
            'note'                  : note,
            'totalPricePerProduct'  : totalPricePerProduct,
            'totalPriceAll'         : totalPriceAll,
        }); 
    }else{
        cart[cartId] = { 
            'idMerchant'            : merchantId,
            'idProduct'             : productId,
            'qty'                   : qty,
            'weight'                : weight,
            'totalWeight'           : totalWeight,
            'variant'               : variant,
            'attribute'             : attribute,
            'extraAttribute'        : extraAttribute,
            'note'                  : note,
            'totalPricePerProduct'  : totalPricePerProduct,
            'totalPriceAll'         : totalPriceAll,
        }; 
    }

    sessionStorage.setItem(nameCart, JSON.stringify(cart));
}

