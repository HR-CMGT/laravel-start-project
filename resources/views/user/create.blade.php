<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create new user</title>
</head>
<body>
    <h1>Create new user</h1>
    {!! Form::open(['url' => 'users']) !!}
    <div>
        {!! Form::text('firstname', 'voornaam') !!}
        <span>{{ $errors->first('firstname') }}</span>
    </div>
    {!! Form::submit() !!}
    {!! Form::close() !!}

    {{ link_to('/', 'hoi') }}
</body>
</html>