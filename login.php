<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Content-Review-Plattform</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
    <div class="login text-center">
        <h1 class="mb-4">Login</h1>
        <form class="text-center mb-2" action="includes/login.inc.php" method="post">
            <div class="mb-3">
                <input class="form-control" type="text" name="name" required placeholder="Name">
            </div> 
            <div class="mb-3">
                <input class="form-control" type="password" name="password" required placeholder="Passwort">
            </div>     
            <input class="btn btn-primary w-50" name="login_submit" type="submit" value="Login">        
        </form>
        <a href="register.php">Registrieren</a>
        <a href="profile.php">Profil</a>
    </div>    
</body>
</html>