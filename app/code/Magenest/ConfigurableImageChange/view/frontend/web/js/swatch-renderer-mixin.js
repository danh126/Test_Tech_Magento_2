define([
    'jquery'
], function ($) {
    'use strict';

    return function (SwatchRenderer) {
        return SwatchRenderer.extend({
            _OnClick: function ($this, $widget) {
                this._super($this, $widget);

                // Lấy data sản phẩm con
                var selectedProductId = this.getProductId();
                if (selectedProductId) {
                    var imageUrl = this.options.jsonConfig.images[selectedProductId][0]['img'];
                    if (imageUrl) {
                        this._updateProductImage(imageUrl);
                    }
                }
            },

            _updateProductImage: function (imageUrl) {
                $('.gallery-placeholder__image').attr('src', imageUrl);
            }
        });
    };
});
