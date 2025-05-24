define(['uiComponent', 'ko', 'jquery'], function (Component, ko, $) {
    return Component.extend({
        initialize: function () {
            this._super();

            // this.options là mảng được Magento truyền qua init
            this.options = ko.observableArray(this.options ? this.options : []);

            // Lấy giá trị mặc định nếu có hoặc 'default'
            this.selectedColor = ko.observable(this.selectedColor || 'default');

            // Đổi màu nền khi chọn
            this.selectedColor.subscribe(function (newColor) {
                if (newColor === 'default') {
                    $('body').css('background-color', ''); // xóa màu nền
                } else {
                    $('body').css('background-color', newColor);
                }
            });

            // Áp lại màu khi load trang nếu có giá trị
            if (this.selectedColor()) {
                if (this.selectedColor() === 'default') {
                    $('body').css('background-color', '');
                } else {
                    $('body').css('background-color', this.selectedColor());
                }
            }
        }
    });
});
