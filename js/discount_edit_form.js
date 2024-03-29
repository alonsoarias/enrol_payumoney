// File: /enrol/payumoney/js/discount_edit_form.js

M.util.js_pending('discount_edit_form.js');

function discount_edit_form_js_init() {
    var discountTypeSelect = document.getElementById('id_discounttype');
    var discountFields = {
        'percentage': ['discount'],
        'fixed': ['discount'],
        'limitedtime': ['discount', 'start_date', 'end_date']
    };

    function hideFields(fields) {
        fields.forEach(function(field) {
            var element = document.getElementById('id_' + field);
            if (element) {
                element.style.display = 'none';
            }
        });
    }

    function showFields(fields) {
        fields.forEach(function(field) {
            var element = document.getElementById('id_' + field);
            if (element) {
                element.style.display = '';
            }
        });
    }

    hideFields(['discount', 'start_date', 'end_date']); // Initially hide all fields

    discountTypeSelect.addEventListener('change', function() {
        var selectedType = this.value;
        var fieldsToShow = discountFields[selectedType];
        for (var type in discountFields) {
            if (type !== selectedType) {
                hideFields(discountFields[type]);
            }
        }
        if (fieldsToShow) {
            showFields(fieldsToShow);
        }
    });
}

M.util.js_complete('discount_edit_form.js');
