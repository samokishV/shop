$(document).ready(function() {
    //update order by id
    $(".order-edit").submit(function(e) {
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

    //update all orders status
    $("#orderEditBtn").on("click", function(e) {
        e.preventDefault();
        var promises = [];
        arr = $(":input[type=checkbox]");

        $.each(arr, function(i, el) {
            id = el.id;
            processed = $(this).is(":checked");
            if(processed) processed = "on";
            else processed = null;

            request = $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '/admin/order/edit/'+id,
                data: {'processed': processed},
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
            window.location.href="/admin/order";
        })


    });
});