<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje directo</title>
</head>
<body>
    <h1>¡Tienes un nuevo mensaje de {{ $sender->username }}!</h1>
    <p>{{ $message->content }}</p>
    @if ($message->image_path)
        <img src="{{ asset('storage/' . $message->image_path) }}" alt="Imagen adjunta">
    @endif
    <p><a href="{{ url('/messages/' . $sender->username) }}">Ver conversación</a></p>
</body>
</html>