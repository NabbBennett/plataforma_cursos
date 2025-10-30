<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Código de Verificación</title>
</head>
<body>
    <h2>¡Gracias por registrarte en Instituto Resiliencia!</h2>

    <p>Tu código de verificación es:</p>

    <h3 style="color:blue">{{ $user->verification_code }}</h3>

    <p>Ingresa este código en la página de verificación para completar tu registro.</p>

    <p>Si no te registraste tú, puedes ignorar este mensaje.</p>
</body>
</html>
