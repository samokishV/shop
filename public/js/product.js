$(document).ready(function() {

    const featureTemplate = $("#feature-template");
    const html = featureTemplate.html();

    //update product promo status
    $(".product-edit").submit(function(e) {
        e.preventDefault();

        var type = 'post';
        var href = $(this).attr('action');
        var str = $(this).serialize();

        customFunc(type, href, str, function() {});
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

            var type = 'post';
            var href = '/admin/product/edit-promo/'+id;
            var str = {'promo': promo};

            request = customFunc(type, href, str, function() {});
            promises.push( request);

        });

        $.when.apply(null, promises).done(function(){
            window.location.href="/admin/product";
        })
    });

    //delete product by id
    $(".product-delete").on("click", function(e) {
        e.preventDefault();

        var type = 'DELETE';
        var href = $(this).attr('href');
        var str = {};

        request = customFunc(type, href, str, function() {});
        $(this).closest("tr").remove();
    });

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
            var featureName = features[i].value;
            var featureValue = values[i].value;

            if(featureName) {
                obj[featureName] = featureValue;
            }
        });

        additional = JSON.stringify(obj);
        $("#additional").val(additional);

        $(this).unbind('submit').submit();
    });

    $('.remove-feature').on('click', function(e) {
        $(this).closest('.feature-group').remove();
    });

});