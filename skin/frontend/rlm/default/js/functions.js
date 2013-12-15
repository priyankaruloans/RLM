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
}

jQuery('document').ready(function () {
    var deliveryInfo = new Popup();
    deliveryInfo.init('li.delivery-info a', '.popup.delivery_info', '.overflow-bg', '.close');

    var contactUsForm = new Popup();
    contactUsForm.init('li.contact a', '.popup.contact_us', '.overflow-bg', '.close');
})
