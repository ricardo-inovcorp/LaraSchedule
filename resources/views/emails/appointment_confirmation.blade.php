<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmação de Agendamento</title>
</head>
<body>
    <h2>Olá, {{ $appointment->name }}!</h2>
    <p>Seu agendamento foi realizado com sucesso.</p>
    <p>
        <strong>Evento:</strong> {{ $appointment->event->name ?? 'Evento' }}<br>
        <strong>Data/Hora:</strong> {{ $appointment->start_datetime }}
    </p>
    <p>Obrigado por usar o LaraSchedule!</p>
</body>
</html> 