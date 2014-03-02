function Popup () {}

Popup.prototype.init = function (clicked, popup, background, close) {
    clicked    = jQuery(clicked);
    popup      = jQuery(popup);
    background = jQuery(background);
    close      = jQuery(close);

    clicked.click(function (e) {
        e.preventDefault();

        background.show();
        popup.fadeIn();
    });

    popup.find(close).click(function () {
        popup.fadeOut(function () { background.hide() });
    });

    background.click(function () {
        popup.find(close).trigger('click');
    });
};

function TopMenu () {}

TopMenu.prototype.init = function (topMenu, topMenuShow) {
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

jQuery('document').ready(function () {
    var deliveryInfo = new Popup();
    deliveryInfo.init('li.delivery-info a', '.popup.delivery_info', '.overflow-bg', '.close');

    var contactUsForm = new Popup();
    contactUsForm.init('li.contact a', '.popup.contact_us', '.overflow-bg', '.close');

    var topMenu = new TopMenu();
    topMenu.init('.header-container', '.show-menu');
});
