$(document).ready(function() {
    //delete category by id
    $(".category-delete").on("click", function(e) {
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

    $('#image').change(function () {
        var input = $(this)[0];
        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                console.log('not image');
            }
        } else {
            console.log('something went wrong');
        }
    });
});
