







$(document).ready(function () {


    let cart = $(".mycart i"),
        addToCart = $(".add-to-cart");
    // deleteProduct = $(".product .delete");

    $(".products").on("click", ".delete", function () {
        $(this).parent().next().remove();
        $(this).parent().parent().remove();
    });
    cart.on("click", function () {
        cart.prev().toggle();
    });



    $(document).on("click", ".increase", function () {



        let = productId = $(this).parent().parent().parent().parent().find(".product-id"),
            productAmount = $(".product" + productId.val() + "").find(".product-amount"),
            productPrice = $(".product" + productId.val() + "").find(".product_price"),
            productNewPrice = $(".product" + productId.val() + "").find(".product-new-price"),
            amount = parseInt(productAmount.val()) + 1,
            price = parseFloat(productPrice.text().match(/\d/g).join("")) * amount;


        productAmount.val(amount);
        productNewPrice.text(price);


    });

    $(document).on("click", ".decrease", function () {
        let = productId = $(this).parent().parent().parent().parent().find(".product-id"),
            productAmount = $(".product" + productId.val() + "").find(".product-amount"),
            productPrice = $(".product" + productId.val() + "").find(".product_price"),
            productNewPrice = $(".product" + productId.val() + "").find(".product-new-price"),
            amount = parseInt(productAmount.val()) - 1,
            price = parseFloat(productPrice.text().match(/\d/g).join("")) * amount;

        if (amount >= 1) {
            productAmount.val(amount);
            productNewPrice.text(price);

        }
    });


    $(document).on("click", ".inside-cart-increase", function () {



        let = productId = $(this).parent().parent().find(".product-id"),
            productAmount = $(".product" + productId.val() + "").find(".product-amount"),
            productPrice = $(".product" + productId.val() + "").find(".product_price"),
            productNewPrice = $(".product" + productId.val() + "").find(".product-new-price"),
            amount = parseInt(productAmount.val()) + 1,
            price = parseFloat(productPrice.text().match(/\d/g).join("")) * amount;


        productAmount.val(amount);
        productNewPrice.text(price);


    });

    $(document).on("click", ".inside-cart-decrease", function () {
        let = productId = $(this).parent().parent().find(".product-id"),
            productAmount = $(".product" + productId.val() + "").find(".product-amount"),
            productPrice = $(".product" + productId.val() + "").find(".product_price"),
            productNewPrice = $(".product" + productId.val() + "").find(".product-new-price"),
            amount = parseInt(productAmount.val()) - 1,
            price = parseFloat(productPrice.text().match(/\d/g).join("")) * amount;

        if (amount >= 1) {
            productAmount.val(amount);
            productNewPrice.text(price);

        }
    });


});
