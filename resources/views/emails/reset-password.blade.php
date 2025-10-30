<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
</head>
<body>
    <h2>Hola {{ $user->name }},</h2>
    <p>Recibiste este correo porque solicitaste restablecer tu contraseña.</p>
    <p>
        <a href="{{ $url }}" style="background: #004754; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Restablecer contraseña
        </a>
    </p>
    <p>Si no solicitaste el cambio, puedes ignorar este mensaje.</p>
</body>
</html>