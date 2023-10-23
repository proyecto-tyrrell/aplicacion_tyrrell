

from pypdf import PdfReader, PdfWriter


from aplicacion_tyrrell.conexionDB import cursor


results = cursor
print(results)

# Diccionario que asocia cada página con el nombre de la persona
personas = {
    0: "Juan Perez",
    1: "Maria Lopez",
    # Agrega aquí el resto de las personas y sus páginas correspondientes
}

def leerRecibo(filename):

    leerR = PdfReader(filename)
    print(f'recibos: \n {leerR.pages[].extract_text()}')



cursor.close()