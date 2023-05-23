import mysql.connector

# Establece la conexión con la base de datos
conn = mysql.connector.connect(
    host='45.151.120.12',       # Dirección del servidor de la base de datos
    user='u602072991_root',      # Nombre de usuario
    password='Br#1+6h:7Me',  # Contraseña
    database='u602072991_Asistencia'  # Nombre de la base de datos
)

# Crea un cursor para ejecutar consultas
cursor = conn.cursor()

# Ejemplo: Recupera los registros de una tabla llamada 'personas'
cursor.execute("SELECT dni FROM usuarios")
rows = cursor.fetchall()

for row in {len(rows)}:
    print(row)

# Cierra el cursor y la conexión con la base de datos
cursor.close()
conn.close()


