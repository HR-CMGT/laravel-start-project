<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    <section>
        <ul>
            <li><a href="/">Link naar deze pagina.</a></li>
            <li><a href="{{ url('/contact') }}">Aanmaken van een nieuwe pagina</a></li>
            <li><a href="{{ url('/users/create') }}">Werken met formulieren</a></li>
        </ul>
    </section>
</body>
</html>