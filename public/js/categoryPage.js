
$(document).ready(function() {

    var newval=$("[name=price]").val();
    $("#slidernumber").text(newval);

    $("[type=range]").change(function(){
        var newval=$(this).val();
        $("#slidernumber").text(newval);

    });

    $("[name='sort-options']").on('change', function() {
        document.forms['myForm'].submit();
    });

});

