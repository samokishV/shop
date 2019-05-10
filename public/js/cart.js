$(document).ready(function() {

    //add product to cart
    $(".products").submit(function() {
        var str = $(this).serialize();
        $.ajax({
            type: 'post',
            url: '/cart/add',
            data: str,
            success: function(data) {
                alert(data);

                if(data == "Product successfully add to cart") {
                    number = $('#products_number').html() - 0;
                    number++;
                    $('#products_number').html(number);
                }
            }
        });
        return false;
    });

    //delete product from cart by id
    $(".products-delete").submit(function() {
        var str = $(this).serialize();
        $.ajax({
            type: 'post',
            url: $(this).attr('action'),
            data: str,
            success: function(data) {
                if(data) {
                    number = $('#products_number').html() - 0;
                    number--;
                    $('#products_number').html(number);
                }
            },
            error: function( req, status, err ) {
                alert('something went wrong', status, err );
            }
        });
        $(this).remove();
        return false;
    });

    //delete all products from cart
    $("#cart-delete").submit(function() {
        var str = $(this).serialize();
        $.ajax({
            type: 'post',
            url: '/cart/delete',
            data: str,
            success: function(result) {
                $('#products_number').html("0");
            },
            error: function( req, status, err ) {
                alert('something went wrong', status, err );
            }
        });

        $(".products-delete").remove();
        return false;
    });

    //update cart before open order page
    $("#orderLink").on("click", function(e) {
        e.preventDefault();
        var promises = [];

        $.each(arr, function(i, el) {
            id = el.id;
            qt = el.value - 0;

            request = $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '/cart/update/'+id,
                data: {'qt': qt},
                success: function(result) {
                    //
                },
                error: function( req, status, err ) {
                    alert('something went wrong'+ status + err );
                }
            });

            promises.push( request);

        });

        $.when.apply(null, promises).done(function(){
            window.location.href="/order/";
        })
    });

    $(":input").bind('keyup change click', function (e) {
        if (! $(this).data("previousValue") || $(this).data("previousValue") != $(this).val()) {
            change_value(this);
            $(this).data("previousValue", $(this).val());
        }
    });

    arr = $(":input[type=number]");

    $.each(arr, function(i, el) {
        change_value(el);
    });


    function change_value(el)
    {
        id = el.id;
        qt = el.value - 0;
        price = $("#" + id + "price").html() - 0;
        total = price * qt;
        $("#" + id + "qt").html(qt);
        $("#" + id + "total").html(total);
    }
});
