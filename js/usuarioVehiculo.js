$(document).ready(function() {
    $('#miTabla').on('click', '.3[data-toggle="modal"]', function() {
        
        var usuarioVehiculo = $(this).data('usuariovehiculo');

        // Crear una tabla HTML para mostrar las observaciones
        var tableHTML;

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
});