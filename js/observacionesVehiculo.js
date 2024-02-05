$(document).ready(function() {
    $('#miTabla').on('click', '.dropdown-item[data-toggle="modal"]', function() {
        
        var observaciones = $(this).data('observaciones');

        // Crear una tabla HTML para mostrar las observaciones
        var tableHTML;

       // Verificar si observaciones es un array y tiene elementos
       if (Array.isArray(observaciones) && observaciones.length > 0) {
            tableHTML = '<table class="table table-striped"><thead><tr><th class="text-center">Fecha</th><th class="text-center">Observaciones</th><th class="text-center">Resuelto</th></tr></thead><tbody>';
            // Iterar sobre las observaciones
            for (var i = 0; i < observaciones.length; i++) {                

                // Construir la fila de la tabla
                tableHTML += '<tr><td class="text-center text-nowrap">' + observaciones[i].fecha + '</td><td class="text-center">' + observaciones[i].mensaje + '</td>';
                
                // Verificar si la observación está resuelta
                if (observaciones[i].resuelto == 1) {
                    tableHTML += '<td class="text-center"><i class="bi bi-check-lg"></i></td>';
                }else{
                    tableHTML += '<td class="text-center"><i class="bi bi-x"></i></td>';
                }
                // No agregar ningún texto si no está resuelta (resuelto == 0)

                tableHTML += '</tr>';
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