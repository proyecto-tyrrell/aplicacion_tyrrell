import mysql.connector

def ejecutar_query(query):
    # Establecer la conexión a MySQL (reemplaza los valores con tus detalles de conexión)
    connection = mysql.connector.connect(
    host='45.151.120.12',
    database='u602072991_Asistencia',
    user='u602072991_root',
    password='Br#1+6h:7Me'

    )
    
    """
# Verificar si la conexión se estableció correctamente
if connection.is_connected():
    print("Conexión exitosa a MySQL")
else:
    print("No se pudo establecer la conexión a MySQL")
"""

    # Crear un cursor para ejecutar la consulta
    cursor = connection.cursor()

    try:
        # Ejecutar la consulta
        cursor.execute(query)

        # Obtener los resultados, si los hay
        resultados = cursor.fetchall()

        # Hacer commit para confirmar los cambios (solo si es una consulta de escritura/modificación)
        connection.commit()

        # Cerrar el cursor y la conexión
        cursor.close()
        connection.close()

        # Devolver los resultados, si los hay
        return resultados

    except Exception as e:
        # Manejar cualquier excepción o error que ocurra
        print("Error:", e)

        # Revertir cualquier cambio pendiente (solo si es una consulta de escritura/modificación)
        connection.rollback()

        # Cerrar el cursor y la conexión
        cursor.close()
        connection.close()

        # Devolver None o algún otro valor indicativo de error
        return None
