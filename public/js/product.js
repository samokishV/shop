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

    //delete product by id
    $(".product-delete").on("click", function(e) {
        e.preventDefault();
        href = $(this).attr('href');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: href,
            type: 'DELETE',
            success: function(result) {
                //
            },
            error: function( req, status, err ) {
                alert('something went wrong'+ status + err );
            }
        });
        $(this).closest("tr").remove();
    });

    html = `<div class='row mt-4 mb-4 feature-group'>
                <div class='col-sm-5'>
                    <label>Feature name</label>
                    <input class='feature w-100'>
                </div>
                <div class='col-sm-5'>
                    <label>Value</label>
                    <input class='feature-value w-100'>
                </div>
                <div class="col-sm-2 my-auto">
                    <a class="btn btn-sm btn-success text-light remove-feature">Delete feature</a>
                </div>
            </div>`;

    $("#add-new-feature").on("click", function(e) {
        $(html).insertAfter("#new-features");

        $('.remove-feature').on('click', function(e) {
            $(this).closest('.feature-group').remove();
        });
    });

    $("#product-add").submit(function(e) {
        e.preventDefault();
        obj = {};

        features = $(".feature");
        values = $(".feature-value");

        $.each(features, function(i, name) {
            obj[features[i].value] = values[i].value;
        });

        additional = JSON.stringify(obj);
        $("#additional").val(additional);

        $(this).unbind('submit').submit();
    });

    $('.remove-feature').on('click', function(e) {
        $(this).closest('.feature-group').remove();
    });

});