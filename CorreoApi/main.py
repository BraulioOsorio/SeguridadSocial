from fastapi import FastAPI,Form
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
import random
from email.message import EmailMessage
import ssl
import smtplib
import mysql.connector
from datetime import datetime, timedelta

# Conectar a la base de datos
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="seguridad_social"
)

cursor = db.cursor()



app = FastAPI()

class Registro(BaseModel):
    nombre_usuario: str
    correo: str
    telefono: str


app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.post("/pagoPendiente/{destinatarios}/{nom_usuario}")
def recordarPago(destinatarios,nom_usuario):
    try:

        correo_envia = "adsoware@gmail.com"
        contraseña = "password"

        asunto = f"Recordatorio de pago"
        cuerpo = f"""
                {nom_usuario} le recordamos que hoy es el dia de pago del plan de seguro \n\n
                Visita cualquiera de nuestras oficinas. !Te esperamos!
                """

        correo = EmailMessage()
        correo["From"] = correo_envia
        correo["To"] = destinatarios
        correo["Subject"] = asunto
        correo.set_content(cuerpo)

        contexto = ssl.create_default_context()

        with smtplib.SMTP_SSL("smtp.gmail.com", 465, context=contexto) as smtp:
            smtp.login(correo_envia, contraseña)

            for destinatario in destinatarios:
                correo.replace_header("To", destinatario)
                smtp.sendmail(correo_envia, destinatario, correo.as_string())

        print("Correo enviado.")
        return {"status":"true","msg":"correo enviado exitosamente"}
    except Exception as e:
        print(f"Error al enviar correo: {str(e)}")
        return {"status":"false","msg":"error al enviar el correo"}
    
@app.post("/recuperarPassw")
def recuPasw(destinatario:str = Form(...)):
    try:
        codigo = random.randint(1000, 9999)
        expiration_time = datetime.now() + timedelta(hours=1)

        query = "INSERT INTO recuperar_passw (correo,token,expiration_time) VALUES (%s, %s, %s)"
        values = (destinatario,codigo,expiration_time)
        cursor.execute(query,values)
        db.commit()

        correo_envia = "info.integrando.pagos@gmail.com"
        contraseña = "ybat olsp cotz lkfv"
        asunto = f"Recuperacion de contraseña"

        correo = EmailMessage()
        correo["From"] = correo_envia
        correo["To"] = destinatario
        correo["Subject"] = asunto
  

        # Crear el cuerpo del correo en HTML
        cuerpo = f"""
            <html>
            <head>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
                    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            </head>
            <body>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="https://i.ibb.co/TB6F689/logo-completo.png" class="img-fluid mb-2" alt="empresa">
                            <h2>Este es tu código de verificación:</h2>
                            <h1 style="color: #000739;"><b>{codigo}</b></h1>
                            <h2>No compartas el token con nadie.</h2>
                        </div>
                    </div>
                </div>
            </body>
            </html>
        """

        # Establecer el contenido del correo
        correo.add_alternative(cuerpo, subtype='html')
        contexto = ssl.create_default_context()

        with smtplib.SMTP_SSL("smtp.gmail.com", 465, context=contexto) as smtp:
            smtp.login(correo_envia, contraseña)

            correo.replace_header("To", destinatario)
            smtp.sendmail(correo_envia, destinatario, correo.as_string())

        print("Correo enviado.")
        return {"status":"true","msg":"token enviado exitosamente"}
    except Exception as e:
        print(f"Error al enviar correo: {str(e)}")
        return {"status":"false","msg":"error al enviar el token"}
    

@app.get("/prueba")
def prueba():
    try:
        destinatario = "winderroman3131@gmail.com"
        correo_envia = "info.integrando.pagos@gmail.com"
        contraseña = "ybat olsp cotz lkfv"

        asunto = f"Prueba"
        correo = EmailMessage()
        correo["From"] = correo_envia
        correo["To"] = destinatario
        correo["Subject"] = asunto

        cuerpo = f"""
                <html>
            <head>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
                    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            </head>
            <body>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="https://i.ibb.co/TB6F689/logo-completo.png" class="img-fluid mb-2" alt="empresa">
                            <h2>Este es tu código de verificación:</h2>
                            <h1 style="color: #000739;"><b>2112</b></h1>
                            <h2>No compartas el token con nadie.</h2>
                        </div>
                    </div>
                </div>
            </body>
            </html>
                """

        correo.add_alternative(cuerpo, subtype='html')

        contexto = ssl.create_default_context()

        with smtplib.SMTP_SSL("smtp.gmail.com", 465, context=contexto) as smtp:
            smtp.login(correo_envia, contraseña)
            correo.replace_header("To", destinatario)
            smtp.sendmail(correo_envia, destinatario, correo.as_string())

        print("Correo enviado.")
        return {"status":"true","msg":"correo enviado exitosamente"}
    except Exception as e:
        print(f"Error al enviar correo: {str(e)}")
        return {"status":"false","msg":"error al enviar el correo"}
