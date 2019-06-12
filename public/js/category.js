$(document).ready(function() {
    //delete category by id
    $(".category-delete").on("click", function(e) {
        e.preventDefault();

        var type = 'delete';
        var href = $(this).attr('href');
        var str = {};

        customFunc(type, href, str, function() {});

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
