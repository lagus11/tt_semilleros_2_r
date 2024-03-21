<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <style>
        body {
            display: flex;
            justify-content: center; 
            align-items: start;
            height: 100vh; 
            margin: 0;
        }
        .ticket-content {
            text-align: start; 
        }
    </style>
</head>
<body>
    <div class="ticket-content">
        <h1>Ticket</h1>
        <p>Nombre: {{ $nombre }}</p>
        <p>Libro: {{ $book_title }}</p>
        <p>Deseado: {{ $desired == 1 ? 'Si' : 'No' }}</p>
        <p>Fecha de Inicio: {{ $start_date }}</p>
        <p>Fecha de Final: {{ $end_date }}</p>
        <br />
        <label><strong>Total:</strong> ${{ $amount }}</label>
    </div>
</body>
</html>
