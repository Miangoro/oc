<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo de Notificación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #00587A;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header img {
            height: 50px;
        }
        .container {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .primary-headline {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333333;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
            color: #333333;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 16px;
            color: #ffffff;
            background-color: #00587A;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            background-color: #00587A;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .social-media a {
            margin: 0 10px;
            text-decoration: none;
        }
        .social-media img {
            height: 20px;
        }
        img{
            width: 160px;

        }
    </style>
</head>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td bgcolor="#00587A" align="center" style="padding: 20px; color: #ffffff;">
                <img src="https://cidam.org/sitio/recursos/img/logo_cidam_new.png" alt="Logo">
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" style="padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <h1 style="font-size: 24px; margin-bottom: 10px; color: #333333;">NOTIFICACIÓN</h1>
                <p style="font-size: 16px; line-height: 1.6; color: #333333;">
                    Estimado(a) <strong>Miguel Ángel Gómez Romero</strong>,
                    <br>
                    Se te ha asignado un certificado para Segunda revisión. Puedes entrar a la Plataforma para realizar la revisión en el siguiente link. Recuerda que debes de tener la sesión abierta para entrar correctamente:
                </p>
                <div style="text-align: center; margin-top: 20px;">
                    <a href="#" style="display: inline-block; padding: 15px 30px; font-size: 16px; color: #ffffff; background-color: #00587A; text-align: center; text-decoration: none; border-radius: 5px;">Clic aquí</a>
                </div>
            </td>
        </tr>
        <tr>
            <td bgcolor="#00587A" align="center" style="padding: 20px; color: #ffffff;">
                <p>CIDAM - Agroinnovación, transformando ideas...</p>
                
                <div class="social-media">
                    <a href="#"><img src="{{ url('public/img_correo/facebook-icon.png') }}" alt="Facebook" style="height: 20px;"></a>
                    <a href="#"><img src="{{ url('public/img_correo/twitter-icon.png') }}" alt="Twitter" style="height: 20px;"></a>
                    <a href="#"><img src="{{ url('public/img_correo/youtube-icon.png') }}" alt="YouTube" style="height: 20px;"></a>
                    <a href="#"><img src="{{ url('public/img_correo/instagram-icon.png') }}" alt="Instagram" style="height: 20px;"></a>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
