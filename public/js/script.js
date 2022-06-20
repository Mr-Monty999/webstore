







$(document).ready(function () {

    let increase = $(".increase"),
        decrease = $(".decrease"),
        productAmount = $(".product-amount"),
        productPrice = $(".product_price"),
        productNewPrice = $(".product-new-price"),
        cart = $(".mycart i"),
        deleteProduct = $(".product .delete");

    deleteProduct.on("click", function () {
        $(this).parent().next().remove();
        $(this).parent().remove();
    });
    cart.on("click", function () {
        cart.prev().toggle();
    });


    increase.on("click", function () {
        let amount = parseInt(productAmount.val()) + 1,
            price = parseFloat(productPrice.text()) * amount;

        productAmount.val(amount);
        productNewPrice.text(price);
    });

    decrease.on("click", function () {
        let amount = parseInt(productAmount.val()) - 1,
            price = parseFloat(productPrice.text()) * amount;

        if (amount >= 1) {
            productAmount.val(amount);
            productNewPrice.text(price);

        }
    });


});
