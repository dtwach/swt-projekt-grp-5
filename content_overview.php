<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Übersicht</title>
    <link href="css/content-overview.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js">
    </script>
    <?php
    include './navbar.php';
    ?>
</head>

<body>

    <div class="container">
        <?php
        if (!isset($_SESSION['id'])) {
        } else {
            require 'includes/dbcon.inc.php';
            $user_id = $_SESSION['id'];
            $stmt = $con->prepare("SELECT 
                u.Rolle
                FROM user AS u
                WHERE u.ID = ?;");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_main = $result->fetch_assoc();
            if ($data_main['Rolle'] == 1) {


                echo '<button type="button" class="btn btn-info btn-lg my-2" data-bs-toggle="modal"
            data-bs-target="#addContentModal">Neues Content hinzufügen</button>

        <!-- Modal -->
        <div class="modal fade" id="addContentModal" aria-labelledby="addContentLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <!-- Modal Inhalt -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addContentLabel">Neues Content hinzufügen</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Name, description, image(file picker) -->

                        <form action="includes/create_content.inc.php" id="form1" method="POST" enctype="multipart/form-data">
                            <div class="form-group my-3">
                                <label for="contentName">Titel</label>
                                <input type="text" class="form-control" id="contentName"
                                    placeholder="Enter content name" name="name_content">
                            </div>
                            <div class="form-group my-3">
                                <label for="contentDescription">Beschreibung</label>
                                <input type="text" class="form-control" id="contentDescription"
                                    placeholder="Enter description" name="contentDescription">
                            </div>
                            <div class="form-group my-3">
                                <label for="contentImg" class="form-label">Contentbild</label>
                                <input class="form-control" type="file" id="contentImg" name="contentImg" accept=".jpg, .jpeg, .png">
                            </div>
                            <div class="form-group my-3">
                            <label for="content_kategorie">Kategorie:</label>
                            <select class="form-select" id="kategorie_select" name="kategorie_select">
                              <option value="1">Videospiel</option>
                              <option value="2">Film</option>
                              <option value="3">Serie</option>
                              <option value="4">Buch</option>
                              <option value="5">Musik</option>
                              </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-default btn-outline-danger"
                            data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" form="form1" name="content_submit" class="btn btn-outline-success"
                            data-bs-dismiss="modal">Fertig</button>
                    </div>
                </div>
            </div>
        </div>';
            }
        }
        ?>


        <div class="row no-gutter">
            <?php
            require 'includes/dbcon.inc.php';
            $stmt = $con->prepare("SELECT c.ID,c.Titel,c.Beschreibung,c.Kategorie,c.Bild,k.Kategoriebezeichnung FROM content AS c
            JOIN kategorie as k on k.ID = c.Kategorie
            ORDER by c.Titel ASC
            ;");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_array()) {
                $picture = (is_null($row['Bild'])) ? "./img/content_ph.jpg" : "data:image/jpeg;base64," . base64_encode($row['Bild']);

                echo '
                <div class="col-12 col-xl-4 col-lg-6 px-0">
                        <div class="row no-gutter border m-1">
                            <a style="margin: 0 auto;"href="content.php?id=' . $row["ID"] . '">
                                <h4 class="col-12 text-center">' . $row["Titel"] . '</h4>
                                <div class="col-12 text-center" style="height: 300px;  margin: auto">
                                    <img style="object-fit: contain;width: 100%;height: 100%;" src="' . $picture . '" class="rounded-2" alt="">
                                </div>
                            </a>
                            <div class="col">';
                echo 'Kategorie:  <a href="search.php?search=category:' . $row["Kategoriebezeichnung"] . '">' . $row["Kategoriebezeichnung"] . '</a>';
                echo '<div class="card-block px-2 mx-1" style="max-height: 110px; text-align: justify;">';
                if ($row['Beschreibung'] == NULL) {
                    echo '<p class="card-text truncate-max-3lines">Keine Beschreibung vorhanden!</p>';
                } else {
                    echo '<p class="card-text truncate-max-3lines">' . $row["Beschreibung"] . '</p>';
                }
                echo '               
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            ?>

        </div>
    </div>

</body>

</html>