$(document).ready(function() {
    //delete user by id
    $(".user-delete").on("click", function(e) {
        e.preventDefault();

        var type = 'DELETE';
        var href =  $(this).attr('href');
        var str = $(this).serialize();

        request(type, href, str, function() {});

        $(this).closest("tr").remove();
    });
});