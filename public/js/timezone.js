$(document).ready(function() {
    var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    $(":input.timezone").val(timezone);
});