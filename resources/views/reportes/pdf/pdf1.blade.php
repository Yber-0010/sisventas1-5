<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .table{
            width: 100%;
            border: 1 px solid #999999;
        }
    </style>
</head>
<body>
    <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id}}</td>    
                <td>{{ $user->name}}</td>    
                <td>{{ $user->email}}</td>    
            </tr>    
            @endforeach
        </tbody>
    </table>
</body>
</html>