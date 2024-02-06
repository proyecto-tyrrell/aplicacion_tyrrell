$(document).ready(function() {
    $('#miTabla').on('click', '.dropdown-item[data-toggle="modal"]', function() {
        
        var observaciones = $(this).data('observaciones');
        var rol = $(this).data('rol');

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
                    if (rol === 'adm') {
                        tableHTML += '<td class="text-center"><button class="marcar-resuelto-btn btn btn-primary" data-observacion-id="' +observaciones[i].id + '" data-resuelto="0">Marcar como no resuelto</button></td>';
                    }
                }else{
                    tableHTML += '<td class="text-center"><i class="bi bi-x"></i></td>';
                    // Mostrar el botón de marcar como resuelto solo si el rol es 'adm'
                    if (rol === 'adm') {
                        tableHTML += '<td class="text-center"><button class="marcar-resuelto-btn btn btn-primary" data-observacion-id="' +observaciones[i].id + '" data-resuelto="1">Marcar como resuelto</button></td>';
                    }
                }

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

        // Evento para marcar como resuelto o no resuelto
        $('#myModal').on('click', '.marcar-resuelto-btn', function() {
            var observacionId = $(this).data('observacion-id');
            var resuelto = $(this).data('resuelto');

            window.location.href = 'marcarResuelto.php?observacionId=' + observacionId + '&resuelto=' + resuelto;

            console.log('El valor de data-observacion-id es: ' + observacionId);
            console.log('El valor de resuelto es:' + resuelto);
        });
    });
});