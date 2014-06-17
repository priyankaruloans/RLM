function Popup (clicked, popup, background, close) {
    var $this  = this;

    clicked    = jQuery(clicked);
    popup      = jQuery(popup);
    background = background !== undefined ? jQuery(background) : jQuery('.overflow-bg');
    close      = close      !== undefined ? jQuery(close)      : jQuery('.close');

    this.init = function () {
        clicked.click(function (e) {
            e.preventDefault();
            jQuery('.popup').hide();

            background.show();
            popup.fadeIn();
        });

        popup.find(close).click(function () {
            $this.close();
        });

        background.click(function () {
            $this.close();
        });
    };

    this.close = function () {
        popup.fadeOut(function () { background.hide() });
    };

    this.init();
}

function TopMenu (topMenu, topMenuShow) {
    this.init = function () {
        topMenu = jQuery(topMenu);
        topMenuShow = jQuery(topMenuShow);
        var speed = 500;

        topMenu.find('.hide-button').click(function (e) {
            e.preventDefault();

            topMenu.animate({
                top: '-100px'
            }, speed, function () {
                topMenuShow.animate({
                    top: '0'
                }, speed)
            });
        });

        topMenuShow.click(function (e) {
            e.preventDefault();

            topMenuShow.animate({
                top: '-100px'
            }, speed, function () {
                topMenu.animate({
                    top: '0'
                }, speed)
            });
        });
    };

    this.init();
}

jQuery('document').ready(function () {
    var myAccount  = new Popup('li.top-my-account.login a, #back-to-login', '#sign_in');
    var forgotPass = new Popup('#forgot-password', '#reset-pass');
    var createNew  = new Popup('#create-new', '#create_new');
    var topMenu    = new TopMenu('.header-container', '.show-menu');

    jQuery('#login-form').submit(function () {
        var form = jQuery(this);

        form.ajaxSubmit({
            success: formSuccess
        });
        return false;
    });

    jQuery('#creat-new-form').submit(function () {
        var form = jQuery(this);

        form.ajaxSubmit({
            success: formSuccess
        });
        return false;
    });

    jQuery('#reset-form').submit(function () {
        var form = jQuery(this);

        form.ajaxSubmit({
            success: formSuccess
        });
        return false;
    });

    function formSuccess (data, status, xhr, form) {
        console.log(data);
        if (data.error) {
            form.find('.error-container').empty().append(data.error).show();
        } else if (data[0] && data[0].error) {
            form.find('.error-container').empty().append(data[0].error).show();
        } else if (data.success) {
            setLocation(data.success);
        }
    };

    jQuery('.instagram').click(function () {
        var links = jQuery('.insta-links');

        links.toggle();
    });
});
