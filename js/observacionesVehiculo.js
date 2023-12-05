$(document).ready(function() {
    $('#miTabla').on('click', '.dropdown-item[data-toggle="modal"]', function() {

        var vehiculoId = $(this).data('id');
        
        var observaciones = $(this).data('observaciones');

        // Crear una tabla HTML para mostrar las observaciones
        var tableHTML;

       // Verificar si observaciones es un array y tiene elementos
       if (Array.isArray(observaciones) && observaciones.length > 0) {
            tableHTML = '<table class="table table-striped"><thead><tr><th class="text-center">Fecha</th><th class="text-center">Observaciones</th></tr></thead><tbody>';
            // Iterar sobre las observaciones
            for (var i = 0; i < observaciones.length; i++) {
                // Formatear la fecha en el formato deseado
                var fecha = new Date(observaciones[i].fecha);
                var formattedFecha = fecha.toLocaleDateString('de', {timeZone: "UTC"});

                // Construir la fila de la tabla
                tableHTML += '<tr><td class="text-center">' + formattedFecha + '</td><td class="text-center">' + observaciones[i].mensaje + '</td></tr>';
            }
            tableHTML += '</tbody></table>';
        } else {
            // Manejar el caso en que no haya observaciones
            tableHTML = '<h3 class="text-center">No hay observaciones</h3>'
        }

        // Mostrar la tabla en el modal
        $('#myModal .modal-body').html(tableHTML);

        // Activar el scroll vertical si es necesario
        $('#myModal .modal-body').css('max-height', '400px'); // Ajusta la altura máxima según tus necesidades
        $('#myModal .modal-body').css('overflow-y', 'auto');
    });
});