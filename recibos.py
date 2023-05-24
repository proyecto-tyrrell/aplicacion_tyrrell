from PyPDF2 import PdfReader, PdfWriter
from conexionDB import ejecutar_query

"""
# Llamar a la función ejecutar_query
resultado = ejecutar_query("SELECT * FROM tabla")
print(resultado)

"""


def leeRecibos(nombre_archivo, template_pdf):


    #abrir y leer pdf    
    pdf_file = open(nombre_archivo, 'rb')
    template_file = open(template_pdf, 'rb')
    pdfRecibo = pdfReader(pdf_file)
    pdfTemplate = pdfReader(template_file)
    #cerrar abril y leer pdf

    pdfRecibo.getDocumentIndo()


    info = pdfRecibo.metada 
    
    print(info)
    


    pdf_writer = PdfWriter()
    
    

    
