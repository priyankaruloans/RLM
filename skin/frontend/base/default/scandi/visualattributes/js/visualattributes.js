/**-
 * +
 * Scandiweb - creating a better future
 *
 * Scandi_VisualAttributes
 *
 * @category    Scandi
 * @package     Scandi_VisualAttributes
 * @author      Scandiweb.com <info@scandiweb.com>
 * @copyright   Copyright (c) 2013 Scandiweb.com (http://www.scandiweb.com)
 * @license     http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

/**
 * Extending and adding necessary methods in Product.Config class that is located in /js/varien/configurable.js
 */
Product.Config.prototype.initialize = Product.Config.prototype.initialize.wrap(function(parent, config) {

    /* Initialize container array */
    config.imageConfig.containers = [];
    /* Call parent method */
    parent(config);
    this.settings.each(function(element) {
        this.initializeImageControls(element);

        /* We don't want validator to ignore the element because it is
         * hidden, so it will always report itself as visible */
        element.visible = function() { return true; };
    }.bind(this));
});

Product.Config.prototype.fillSelect = Product.Config.prototype.fillSelect.wrap(function(parent, element) {

    /* Call parent method */
    parent(element);
    this.configureImageControls(element);
});

Product.Config.prototype.initializeImageControls = function(element) {

    if (!this.imagesEnabled(element.config.id)) {
        return;
    }

    var imageConfig = this.config.imageConfig,
        itemTemplate = new Template(imageConfig.itemTemplate),
        emptyItemTemplate = new Template(imageConfig.emptyItemTemplate),
        attributeId = element.config.id,
        options = this.getAttributeOptions(attributeId),
        containerTemplate = new Template(imageConfig.containerTemplate),
        container = element.insert({
            before: containerTemplate.evaluate({container_class: element.config.code})
        }).previous();

    imageConfig.containers[attributeId] = container;

    element.hide();

    options.each(function(option) {
        var imageUrl = this.getOptionImageUrl(element.config.code, option.id),
            optionTemplate =  imageUrl ? itemTemplate : emptyItemTemplate;

        container.insert(optionTemplate.evaluate({
            src: imageUrl,
            width: this.getAttributeImageWidth(attributeId),
            height: this.getAttributeImageHeight(attributeId),
            title: option.label
        }).replace('width=""', '').replace('height=""', ''));

        var imageOption = container.childNodes[this.getOriginalIndex(attributeId, option.id)];

        if (this.getSelectIndex(element, option.id)) {
            Event.observe(imageOption, 'click', this.selectImageOption.bind({
                imageContainer: container,
                selectElement: element,
                imageOption: imageOption,
                index: this.getSelectIndex(element, option.id)
            }));
        } else {
            $(imageOption).addClassName('disabled');
        }
    }.bind(this));

    /* If select element has preconfigured value we set it for image options too */
    if (this.values && this.values[attributeId]) {
        container.childNodes[this.getOriginalIndex(attributeId, element.value)].addClassName('active');
    }
};

Product.Config.prototype.configureImageControls = function(element) {

    var attributeId = element.config.id;

    if (!this.imagesEnabled(attributeId) || this.getContainer(attributeId) === undefined) {
        return;
    }

    /* Add disabled class for every option */
    for (var i=0; i<this.getContainer(attributeId).childNodes.length; i++) {
        this.getContainer(attributeId).childNodes[i].addClassName('disabled').removeClassName('active');
        Event.stopObserving(this.getContainer(attributeId).childNodes[i], 'click');
    }

    /* Loop starts from 1 to bypass "Choose An Option.." */
    for (var k=1; k<element.options.length; k++) {
        var optionIndex = this.getOriginalIndex(attributeId, element.options[k].value),
            imageOption = this.getContainer(attributeId).childNodes[optionIndex].removeClassName('disabled');

        Event.observe(imageOption, 'click', this.selectImageOption.bind({
            imageContainer: this.getContainer(attributeId),
            selectElement: element,
            imageOption: imageOption,
            index: k
        }));
    }
};

Product.Config.prototype.getOptionImageUrl = function(attributeCode, optionId) {
    var optionImages = this.config.imageConfig.optionImage;
    if (optionImages !== undefined && optionImages[optionId] !== undefined) {
        return this.config.imageConfig.attributeImageMediaUrl + attributeCode + '/' +
            this.config.imageConfig.optionImage[optionId];
    }
    return null;
};

/* Update real select element when option image clicked */
Product.Config.prototype.selectImageOption = function() {

    /* Set selected option on actual select element */
    this.selectElement.selectedIndex = this.index;
    fireEvent(this.selectElement, 'change');

    /* Clear active class from all image options */
    this.imageContainer.childElements().each(function(element) {
        element.removeClassName('active');
    });
    /* Add active class to currently selected option */
    this.imageOption.addClassName('active');
};

Product.Config.prototype.getAttributeImageWidth = function(attributeId) {
    if (this.config.imageConfig.displayConfig[attributeId].width !== '0') {
        return this.config.imageConfig.displayConfig[attributeId].width;
    }
    return null;
};

Product.Config.prototype.getAttributeImageHeight = function(attributeId) {
    if (this.config.imageConfig.displayConfig[attributeId].height !== '0') {
        return this.config.imageConfig.displayConfig[attributeId].height;
    }
    return null;
};

Product.Config.prototype.configureForValues = Product.Config.prototype.configureForValues.wrap(function(parent, event) {
    /* Prevent calling configureForValues second time */
    if (event === undefined) {
        parent();
    }
});

/* Get image container for corresponding attribute */
Product.Config.prototype.getContainer = function(attributeId) {
    return this.config.imageConfig.containers[attributeId];
};

Product.Config.prototype.imagesEnabled = function(attributeId) {
    return this.config.imageConfig.displayConfig[attributeId].useImages !== '0';
};

/* Get options index in configuration */
Product.Config.prototype.getOriginalIndex = function(attributeId, optionValue) {
    var options = this.config.attributes[attributeId].options;
    for (var i=0; i<options.length; i++) {
        if (options[i].id == optionValue) {
            return i;
        }
    }
    return false;
};

/* Get options index in select element */
Product.Config.prototype.getSelectIndex = function(options, optionValue) {
    /* Start from 1 to bypass "Choose An Option.." */
    for (var i=1; i<options.length; i++) {
        if (options[i].value == optionValue) {
            return i;
        }
    }
    return false;
};
