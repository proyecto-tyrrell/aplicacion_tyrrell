$(document).ready(function() {
    
    //uso vehiculo
    $('#miTabla').on('click', '.2[data-toggle="modal"]', function() {
        
       let uso = $(this).data('uso');

       let titulo = document.querySelector('#modalUso .modal-title');

       titulo.textContent = "Uso - " + $(this).data('patente');

       // Crear una tabla HTML para mostrar las observaciones
       let tableHTML;

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

    //usuario vehiculo
    $('#miTabla').on('click', '.3[data-toggle="modal"]', function() {
        
       let usuarioVehiculo = $(this).data('usuariovehiculo');

       
       let titulo = document.querySelector('#modalUsuarioVehiculo .modal-title');
       titulo.textContent = "Uso por usuario - " + $(this).data('patente');

        // Crear una tabla HTML para mostrar las observaciones
       let tableHTML;

       // Verificar si observaciones es un array y tiene elementos
       if (Array.isArray(usuarioVehiculo) && usuarioVehiculo.length > 0) {
            tableHTML = '<table class="table table-striped"><thead><tr><th class="text-center">Fecha</th><th class="text-center">Usuario</th></tr></thead><tbody>';
            // Iterar sobre los usos
            for (var i = 0; i < usuarioVehiculo.length; i++) {
                // Construir la fila de la tabla
                tableHTML += '<tr><td class="text-center">' + usuarioVehiculo[i].fecha + '</td><td class="text-center">' + usuarioVehiculo[i].usuario + '</td></tr>';
            }
            tableHTML += '</tbody></table>';
        } else {
            // Manejar el caso en que no haya usos
            tableHTML = '<h3 class="text-center">No hay usos</h3>'
        }

        // Mostrar la tabla en el modal
        $('#modalUsuarioVehiculo .modal-body').html(tableHTML);

        // Activar el scroll vertical si es necesario
        $('#modalUsuarioVehiculo .modal-body').css('max-height', '400px'); // Ajusta la altura máxima según tus necesidades
        $('#modalUsuarioVehiculo .modal-body').css('overflow-y', 'auto');
    });

    //observaciones
    $('#miTabla').on('click', '.dropdown-item[data-toggle="modal"]', function() {
        
       let observaciones = $(this).data('observaciones');
       let rol = $(this).data('rol');

       let titulo = document.querySelector('#myModal .modal-title');
       titulo.textContent = "Observaciones - " + $(this).data('patente');

        // Crear una tabla HTML para mostrar las observaciones
       let tableHTML;

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
           let observacionId = $(this).data('observacion-id');
           let resuelto = $(this).data('resuelto');

            window.location.href = 'marcarResuelto.php?observacionId=' + observacionId + '&resuelto=' + resuelto;

            console.log('El valor de data-observacion-id es: ' + observacionId);
            console.log('El valor de resuelto es:' + resuelto);
        });
    });

});