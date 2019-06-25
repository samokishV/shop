$(document).ready(function() {
    //update order by id
    $(".order-edit").submit(function(e) {
        e.preventDefault();

        var type = 'POST';
        var href = $(this).attr('action');
        var str = $(this).serialize();

        request(type, href, str, function() {});
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

            var type = 'POST';
            var href = route('order.edit', [id]);
            var str = {'processed': processed};

            response = request(type, href, str, function() {});
            promises.push(response);
        });

        $.when.apply(null, promises).done(function(){
            window.location.href = route('admin.order.index');
        });
    });
});