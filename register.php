<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Content-Review-Plattform</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
    <div class="login text-center">
        <h1 class="mb-4">Registrierung</h1>
        <form class="text-center mb-2" action="includes/register.inc.php" method="post">
            <div class="mb-3">
                <?php
                    if (!isset($_GET['name'])) {
                        echo ' <input class="form-control" type="text" name="name" required placeholder="Name">';
                    } else {
                        echo ' <input class="form-control" type="text" name="name" value="' . $_GET['name'] . '" required placeholder="Name">';
                    }
                ?>
            </div> 
            <div class="mb-3">
                <input class="form-control" type="password" name="password" required placeholder="Passwort">
            </div> 
            <div class="mb-3">
                <input class="form-control" type="password" name="password_again" required placeholder="Passwort wiederholen">
            </div>     
            <input class="btn btn-primary w-50" name="register_submit"  type="submit" value="Registrieren">
        </form>
        <a href="index.php">Login</a>
        <div class="row">
            <?php
            // Fehlermeldungen
                isset($_GET['ms']) ? $message = $_GET['ms'] : $message = '';
                if ($message !== '') {
                    switch ($message) {
                        case 'empty':
                            echo '<p>Eingabefelder sind unvollständig</p>';
                            break;
                        case 'even':
                            echo '<p>Passwort stimmt nicht überein</p>';
                            break;
                        case 'db';
                            echo '<p>Fehler an der Datenbank. Bitte versuchen Sie es später erneut</p>';
                            break;
                        case 'taken';
                            echo '<p>Benutzer ist vergeben </p>';
                            break;
                        case 'fail';
                            echo '<p>Bitte versuchen Sie es später erneut</p>';
                            break;
                    }
                }
            ?>          
        </div>
    </div>
</body>
</html>