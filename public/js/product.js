$(document).ready(function() {
    //update product by id
    $(".product-edit").submit(function(e) {
        e.preventDefault();
        href = $(this).attr('action');
        var str = $(this).serialize();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: href,
            type: 'POST',
            data: str,
            success: function(result) {
                //
            },
            error: function( req, status, err ) {
                alert('something went wrong'+ status + err );
            }
        });
        return false;
    });

    //update all product status
    $("#productEditBtn").on("click", function(e) {
        e.preventDefault();
        var promises = [];
        arr = $(":input[type=checkbox]");

        $.each(arr, function(i, el) {
            id = el.id;
            promo = $(this).is(":checked");
            if(promo) promo = "on";
            else promo = null;

            request = $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '/admin/product/edit-promo/'+id,
                data: {'promo': promo},
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
            window.location.href="/admin/product";
        })
    });
});