define(['jquery'], function($) {
    return {
        init: function() {
            function toggleFields(discountType) {
                // Ocultar todos los campos específicos de tipo de descuento por defecto
                $('#fitem_id_name').hide();
                $('#fitem_id_description').hide();
                $('#fitem_id_discountvalue').hide();
                $('#fitem_id_validfrom').hide();
                $('#fitem_id_validto').hide();
                $('#fitem_id_discountcode').hide();
                $('#fitem_id_discountduration').hide();

                // Mostrar campos basados en el tipo de descuento seleccionado
                if (discountType !== '0') {
                    $('#fitem_id_name').show();
                    $('#fitem_id_description').show();
                    $('#fitem_id_discountvalue').show();
                    $('#fitem_id_discountduration').show();
                    // Ajustar visibilidad para tipos de descuento específicos
                    if (discountType === 'limitedtime') {
                        $('#fitem_id_discountcode').show();
                        $('#fitem_id_validfrom').show();
                        $('#fitem_id_validto').show();
                    }
                }
            }

            // Evento al cambiar el tipo de descuento
            $('#id_discounttype').change(function() {
                var selectedType = $(this).val();
                toggleFields(selectedType);
            });

            // Ejecutar al cargar para establecer el estado inicial correcto
            $(document).ready(function() {
                var selectedType = $('#id_discounttype').val();
                toggleFields(selectedType);
            });
        }
    };
});
