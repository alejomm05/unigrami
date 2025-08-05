<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo mensaje directo</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;">
        <h2 style="color: #e1306c;">¡Hola, {{ $notifiable->display_name }}!</h2>

        <p>
            Has recibido un nuevo mensaje de <strong>{{ $message->sender->display_name }} (@{{ $message->sender->username }})</strong>:
        </p>

        <p>
            <strong>Mensaje:</strong> {{ $message->content }}
        </p>

        <p>
            Puedes ver el mensaje completo haciendo clic en el siguiente enlace:
        </p>

        <p>
            <a href="{{ url('/messages/conversation/' . $message->sender->username) }}" style="color: #e1306c; font-weight: bold;">
                Ver conversación con @{{ $message->sender->username }}
            </a>
        </p>

        <hr style="border: 1px solid #eee;">

        <p style="font-size: 0.9em; color: #777;">
            Este es un mensaje automático. Por favor, no respondas a este correo.
        </p>
    </div>
</body>
</html>