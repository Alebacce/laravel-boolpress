<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Ciao!</h1>
    <p>
        Hai un nuovo contatto!
    </p>

    <ul>
        <li>
            Da: {{ $new_contact_data['email'] }}
        </li>

        <li>
            Nome: {{ $new_contact_data['name']  }}
        </li>

        <li>
            Messaggio: {{ $new_contact_data['message']  }}
        </li>
    </ul>
</body>
</html>