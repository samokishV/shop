function customFunc(type, href, str, success) {
    return $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: type,
        url: href,
        data: str,
        success: function (data) {
            success(data);
        },
        error: function (req, status, err) {
            alert('something went wrong', status, err);
        }
    });
}

