$(function () {
    $("#serachitem-latitude").val("test");
    $('.pass-in').hide();
    $('.password-click').click(function () {
        $('.pass-in').toggle(500);
    });

    $('.logout-btn').click(function () {
        $.post('/site/logout');
    });
    $('.forgot-pass').click(function (event) {
        $(".pr-wrap").toggleClass("show-pass-reset");
    });

    $('.pass-reset-submit').click(function (event) {
        $(".pr-wrap").removeClass("show-pass-reset");
    });

    $(".dynamicform_wrapper").on("afterInsert", function (e, item) {
        $('.optionvalue-img:last').fileinput('clear');
    });

    $(".serachBtn").click(function () {
        $("#myModal").modal('show')
            .find("#myModalContent")
            .load($(this).attr('value'));
    });

    $(".addNameBtn").click(function () {
        $("#myModal").modal('show')
            .find("#myModalContent")
            .load($(this).attr('value'));
    });

    $(".lang-item").click(function () {
        $.post(
            '/site/change-language', {},
            function (data) {
                location.reload();
            }
        );
    });

});





