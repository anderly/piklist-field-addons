/* --------------------------------------------------------------------------------
  Piklist Field AddOns
--------------------------------------------------------------------------------- */

var piklist_field_addons;

(function ($) {
    $(document).ready(function () {
        piklist_field_addons.init();
    });

    piklist_field_addons = {

        init: function () {
            if (typeof piklist_fields != 'undefined') {
                piklist_field_addons.fields();
            }
        },

        fields: function () {
            for (var id in piklist_fields) {
                piklist_field_addons.process_fields(id);
            }
        },

        process_fields: function (id) {
            var fields = piklist_field_addons.to_array(piklist_fields[id]);
            for (var i in fields) {
                for (var j in fields[i]) {
                    if (!fields[i][j].display) {
                        piklist_field_addons.process_field(fields[i][j], id);
                    }
                }
            }
        },

        process_field: function (field, fields_id) {
            if (field.id && field.id.indexOf('__i__') > -1) {
                var widget = $('input[value="' + fields_id + '"]:last').parents('.widget').attr('id');
                var n = widget.charAt(widget.length - 1);

                if (!isNaN(parseFloat(n)) && isFinite(n)) {
                    field.id = field.id.toString().replace('__i__', n);
                    field.name = field.name.toString().replace('__i__', n);
                } else {
                    return false;
                }
            }

            var options = typeof field.options === 'object' ? field.options : null;

            switch (field.type) {
                case 'select2':

                    $('#' + field.id)
                        .val($('#' + field.id).val() ? $('#' + field.id).val() : (!field.value ? null : field.value))
                        .select2(options);

                    break;
            }

            if (field.js_callback) {
                window[field.js_callback](field);
            }
        },

        to_array: function (object) {
            return $.map(object, function (o) {
                return [$.map(o, function (v) {
                    return v;
                })];
            });
        },

    };

})(jQuery);
