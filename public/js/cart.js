$(document).ready(function() {
    const productNumber = $('#products_number');

    //add product to cart
    $(".products").submit(function(e) {
        e.preventDefault();
        var type = 'post';
        var href = route('cart.add');
        var str = $(this).serialize();

        request(type, href, str, function(data) {
            alert(data);
            if (data === "Product successfully add to cart") {
                number = productNumber.html() - 0;
                number++;
                productNumber.html(number);
            }
        });
    });

    //delete product from cart by id
    $(".products-delete").submit(function(e) {
        e.preventDefault(e);
        var type = 'post';
        var href = $(this).attr('action');
        var str = $(this).serialize();

        request(type, href, str, function() {
            number = productNumber.html() - 0;
            number--;
            productNumber.html(number);
        });

        $(this).remove();
        arr = $(":input[type=number]");
    });

    //delete all products from cart
    $("#cart-delete").submit(function(e) {
        e.preventDefault(e);
        var type = 'post';
        var href = route('cart.delete.all');
        var str = $(this).serialize();

        request(type, href, str, function() {
            productNumber.html("0");
        });

        $(".products-delete").remove();
    });

    //update cart before open order page
    $("#orderLink").on("click", function(e) {
        e.preventDefault();
        var promises = [];

        $.each(arr, function(i, el) {
            var id = el.id;
            var qt = el.value - 0;

            var type = 'post';
            var href = route('cart.edit', [id]);
            var str = {'qt': qt};

            responce = request(type, href, str, function() {});
            promises.push(responce);
        });

        $.when.apply(null, promises).done(function(){
            window.location.href = route('order');
        })
    });

    $(":input").bind('keyup change click', function (e) {
        if (! $(this).data("previousValue") || $(this).data("previousValue") != $(this).val()) {
            changeQtAndTotal(this);
            $(this).data("previousValue", $(this).val());
        }
    });

    arr = $(":input[type=number]");

    $.each(arr, function(i, el) {
        changeQtAndTotal(el);
    });


    /**
     * Update qt and total value when input number value change.
     *
     * @param inputNumber
     */
    function changeQtAndTotal(inputNumber)
    {
        id = inputNumber.id;
        qt = inputNumber.value - 0;
        price = $("#" + id + "price").html() - 0;
        total = price * qt;
        $("#" + id + "qt").html(qt);
        $("#" + id + "total").html(total);
    }
});
