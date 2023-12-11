$(document).ready(function() {
    $('#miTabla').on('click', '.2[data-toggle="modal"]', function() {
        
        var uso = $(this).data('uso');

        // Crear una tabla HTML para mostrar las observaciones
        var tableHTML;

       // Verificar si observaciones es un array y tiene elementos
       if (Array.isArray(uso) && uso.length > 0) {
            tableHTML = '<table class="table table-striped"><thead><tr><th class="text-center">Proyecto</th><th class="text-center">Usos</th></tr></thead><tbody>';
            // Iterar sobre los usos
            for (var i = 0; i < uso.length; i++) {
                // Construir la fila de la tabla
                tableHTML += '<tr><td class="text-center">' + uso[i].proyecto + '</td><td class="text-center">' + uso[i].cantidad + '</td></tr>';
            }
            tableHTML += '</tbody></table>';
        } else {
            // Manejar el caso en que no haya observaciones
            tableHTML = '<h3 class="text-center">No hay usos</h3>'
        }

        // Mostrar la tabla en el modal
        $('#modalUso .modal-body').html(tableHTML);

        // Activar el scroll vertical si es necesario
        $('#modalUso .modal-body').css('max-height', '400px'); // Ajusta la altura máxima según tus necesidades
        $('#modalUso .modal-body').css('overflow-y', 'auto');
    });
});