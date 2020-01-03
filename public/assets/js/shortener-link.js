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
        var elements = $("[id$='error']");
        $.each(elements, function() {
            $(this).hide();
        });
    }

    function listLinks(data) {
        $('#linksList').append(
            '<li class="list-group-item">' + data.link + data.params
            + ' -> ' + '<a target="_blank" href="' + data.shortLink + data.params
            + '">' + data.shortLink + data.params + '</a>'
            + '</li>'
        )
    }
});