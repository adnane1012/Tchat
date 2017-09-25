$(function () {
    $(".heading-compose").click(function () {
        $(".side-two").css({
            "left": "0"
        });
    });

    $(".newMessage-back").click(function () {
        $(".side-two").css({
            "left": "-100%"
        });
    });
    if (typeof request !== 'undefined' && $.isFunction(myfunc)) {
        request();
    }

})