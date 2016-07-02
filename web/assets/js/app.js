$(function () {
    $('button.link').each(function () {

        var link = $(this).data('link');

        $(this).on('click', function (event) {
            event.preventDefault();
            window.location.href = link;
        })
    });
});
