$(function() {
    var _token = $("input[name='_token']").val();

    $('#create-link').submit(function (e) {
        e.preventDefault();
        hideErrors();
        var inputLink = $("#link").val();
        $.post({
            url: '/create-short-url',
            data: {link:inputLink, _token:_token},
            success: function (data) {
                listLinks(data);
            },
            error: function (data) {
                if (data.hasOwnProperty('responseJSON')) {
                    printErrorMsg(data.responseJSON.errors);
                }
            }
        });
    });

    function printErrorMsg (msg) {
        $.each( msg, function( key, value ) {
            var element = $("#" + key + "-error");
            element.text(value[0]);
            element.show();
            $('#' + key).addClass('is-invalid');
        });
    }

    function hideErrors() {
        var errors = $("[id$='error']");
        $.each(errors, function(key, value) {
            $(this).hide();
        });
        var invalidFields = $('.is-invalid');
        console.log(invalidFields);
        $.each(invalidFields, function(key, value) {
            $(this).removeClass('is-invalid');
        });
    }

    function listLinks(data) {
        $('#linksList').append(
            '<li class="list-group-item">' + data.link + data.params
            + ' -> ' + '<a target="_blank" href="' + data.shortLink
            + '">' + data.shortLink + '</a>'
            + '</li>'
        )
    }
});