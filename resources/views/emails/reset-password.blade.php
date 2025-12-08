<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .instituto-name {
            font-size: 24px;
            font-weight: bold;
            color: #004754;
            margin-bottom: 10px;
        }
        .greeting {
            color: #004754;
            font-size: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .token {
            font-size: 36px;
            font-weight: bold;
            color: #004754;
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            letter-spacing: 5px;
            font-family: 'Courier New', monospace;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="instituto-name">INSTITUTO RESILIENCIA</div>
        </div>
        
        <h2 class="greeting">¡Hola {{ $user->name }}!</h2>
        
        <p style="text-align:center;"><strong>¡Recibiste este correo porque solicitaste restablecer tu contraseña!</strong></p>
        
        <p style="text-align:center;">
            <a href="{{ $url }}" style="background: #004754; color: #fff; padding: 12px 22px; text-decoration: none; border-radius: 6px; display: inline-block;">
                Restablecer contraseña
            </a>
        </p>

        <div class="footer" style="text-align:center;">
            <p>Si no solicitaste el cambio, puedes ignorar este mensaje.</p>
            <p><strong>INSTITUTO RESILIENCIA</strong></p>
        </div>
    </div>
</body>
</html>