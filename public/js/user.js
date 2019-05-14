$(document).ready(function() {
    //delete user by id
    $(".user-delete").on("click", function(e) {
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
});