import PyPDF2
import fitz
import mysql.connector

# Conexión a la base de datos MySQL
conn = mysql.connector.connect(user='root', password='1234', host='127.0.0.1', database='Form_Instalacion')

cursor = conn.cursor()
cursor.execute('SELECT * FROM table_name')

# Crear un nuevo PDF
pdf_writer = PyPDF2.PdfFileWriter()

# Leer el PDF original
with open('NuevaInstalacion.pdf', 'rb') as file:
    pdf_reader = PyPDF2.PdfFileReader(file)

    # Iterar sobre cada página del PDF
    for page_num in range(pdf_reader.getNumPages()):
        page = pdf_reader.getPage(page_num)

        # Iterar sobre cada fila en la base de datos
        for row in cursor:
            # Rellenar el PDF con los valores de la base de datos
            page = fitz.openPage(page_num)
            for column in row:
                page.insertText(column)

        # Añadir la página al nuevo PDF
        pdf_writer.addPage(page)

# Guardar el nuevo PDF
with open('new.pdf', 'wb') as out_file:
    pdf_writer.write(out_file)
