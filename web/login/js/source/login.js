$(function(){
    var $loginForm  = $('#login-form');
    var $errorField = $('#login-form-errorfield');
    var loginUrl    = '/api/authorization/login';
    var timeLiveCookie = 6 * 60 * 60;

    $loginForm.validate({
        submitHandler: function(form) {
            $errorField.removeClass('show');
            $.post(loginUrl,
                    $(form).serialize()
                        + '&appToken=app2121d3ds34gg33asgr23e23ce2asa'
            )
            .then(
                function(d){
                    $errorField.removeClass('show');
                    setCookie('token', d.token, {path: '/', expires: 6 * timeLiveCookie});
                    window.location = '/admin/';
                },
                function(d){
                    $errorField.text(d.responseJSON.error);
                    $errorField.addClass('show');
                }
            );
            return false;
        }
    });
});


function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}