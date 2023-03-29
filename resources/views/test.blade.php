<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <title>Document</title>
</head>
<body>
    <h1>Hello</h1>
    <?php
    use App\Models\User;
    $user= User::find(2);
    ?>
    @if ($user->hasRole('writer'))
        User is admin
        {{$user->name}};
    @else 
      not admin
        {{$user->name}}; 
    @endif
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>