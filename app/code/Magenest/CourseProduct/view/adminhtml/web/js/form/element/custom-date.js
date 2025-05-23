define([
    'Magento_Ui/js/form/element/date',
    'jquery',
    'mage/calendar'
], function (Date, $) {
    'use strict';

    return Date.extend({
        initialize: function () {
            this._super();
            let self = this;

            // Đợi 500ms để DOM render xong
            setTimeout(function () {
                // console.log('✅ Custom Date Init for:', self.inputName);
                let escapedName = self.inputName.replace('[', '\\[').replace(']', '\\]');
                let input = $('input[name="' + escapedName + '"]');

                if (input.length && typeof input.datepicker === 'function') {
                    input.datepicker('option', 'beforeShowDay', function (date) {
                        let day = date.getDate();
                        return (day >= 8 && day <= 12) ? [true, ''] : [false, ''];
                    });
                    // console.log('✅ Datepicker option set for:', self.inputName);
                } else {
                    // console.warn('❌ Input or datepicker not found for:', self.inputName);
                }
            }, 500);

            return this;
        }
    });
});
