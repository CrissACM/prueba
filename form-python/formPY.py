import mysql.connector
from reportlab.pdfgen import canvas

# Conexión a la base de datos MySQL
cnx = mysql.connector.connect(
    user='root',
    password='1234',
    host='localhost',
    database='Nueva_Instalacion')

cursor = cnx.cursor()

# Consulta para obtener los datos
query = ("SELECT * FROM Cliente;")

cursor.execute(query)

# Lectura del PDF
c = canvas.Canvas("NuevaInstalacion.pdf")

# Creación de un nuevo PDF con los datos
c = canvas.Canvas("new.pdf")

y = 750

for row in cursor:
    # Añadir los datos al PDF
    text = ', '.join([str(element) for element in row])
    c.drawString(100, y, text)
    y -= 15

# Guardar el nuevo PDF
c.save()

cursor.close()
cnx.close()
