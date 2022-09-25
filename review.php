<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_GET['uid']) && !isset($_GET['cid'])){
    header('Location: /index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Content-Review-Plattform</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <?php
    include './navbar.php';
    ?>
</head>

<body>
    <?php
        
        require 'includes/dbcon.inc.php';
        $user_id = htmlspecialchars($_GET['uid']);
        $content_id = htmlspecialchars($_GET['cid']);
        $stmt = $con->prepare("SELECT r.Inhalt, r.Bewertung, c.titel, u.Username, c.Bild as Content_Picture, u.Bild as User_Picture
            FROM review as r
            JOIN content as c on c.ID = r.Content 
            JOIN user as u on r.User = u.ID
            WHERE r.User=? AND r.Content=?
            ");
        $stmt->bind_param('ii', $user_id, $content_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        if (!isset($data)){
            echo '
            <div class="container-lg p-4">
                <h1 class="text-center mt-4">  Keine Reviews gefunden!</h1>
            </div>
            ';
        } else {
            $picture = (!isset($data['Content_Picture'])) ? "https://image.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600w-1037719192.jpg" : 
                    "data:image/jpeg;base64," + base64_encode($data['Content_Picture']);

            $user_picture = (!isset($data['User_Picture'])) ? "./img/profil_ph.png" : 'data:image/jpeg;base64,' . base64_encode($row);
            echo'
                <div class="container-lg p-4">
                    <h1 class="text-center">Review</h1>
                    <div class="row">
                        <div class="col-sm-6 d-flex align-items-center mb-3">
                            <img src="' . $user_picture .'" alt="" class="img">
                            <span class="m-3">
                                <p class="mb-1">Von:</p>
                                <p>' . $data['Username'] . '</p>
                            </span>
                        </div>
                        <div class="col-sm-6 d-flex align-items-center justify-content-sm-end mb-3">
                            <img src="' . $picture . '"
                                alt="" class="img">
                            <span class="m-3 order-sm-first">
                                <p class="mb-1 d-flex justify-content-sm-end">Zu:</p>
                                <p class="d-flex justify-content-sm-end">Content</p>
                            </span>
                        </div>
                    </div>
                    <div class="border rounded">
                        <h4 class="text-center m-2">Rating ' . intval($data['Bewertung']) . '/10</h4>
                        <p class="mx-4">' . $data['Inhalt'] . '</p>
                    </div>
                </div>
            ';
            }
    ?>
</body>

</html>