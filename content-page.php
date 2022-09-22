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
    <title>Review: Content Title</title>
    <link href="css/content-page.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="js/contentPage.js" defer></script>

    <?php
    include './navbar.php';
    ?>
</head>

<body>
    <div class="text-center p-sm-4 pt-2">
        <!-- TODO ADD REVIEW MODAL -->
        <h4>Content Title</h4>
        <div class="row row-cols-1 row-cols-md-2 g-2 g-lg-3">
            <div class="col col-md-5">
                <img src="https://image.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600w-1037719192.jpg"
                    class="img-fluid rounded" alt="">
            </div>
            <div class="col col-md-7">
                <div class="row row-cols-2 row-cols-lg-3">
                    <div class="col">
                        <div class="row row-cols-2 row-cols-lg-1">
                            <p class="text-end text-lg-start">Kategorie:</p>
                            <p class="text-start">${kategorie}</p>
                        </div>
                    </div>

                    <div class="col">
                        <div class="row row-cols-2 row-cols-lg-1">
                            <p class="text-end text-lg-start">Rating:</p>
                            <p class="text-start">${rating}</p>
                        </div>
                    </div>

                    <div class="col">
                        <div class="row row-cols-2 row-cols-lg-1">
                            <p class="text-end text-lg-start">Bewertung:</p>
                            <p class="text-start">${bewertung}</p>
                        </div>
                    </div>
                </div>
                <div class="text-start">Lorem ipsum dolor sit amet consectetur,
                    adipisicing elit. Numquam provident sunt ab. Laudantium fuga, odit quae
                    necessitatibus recusandae perferendis eius harum. Ipsum ut magni corrupti,
                    nesciunt labore repudiandae sapiente aspernatur! Numquam provident sunt ab. Laudantium fuga, odit
                    quae
                    necessitatibus recusandae perferendis eius harum. Ipsum ut magni corrupti,
                </div>

                <div class="d-flex justify-content-evenly pt-4 px-4">
                    <button class="px-2 rounded-4 border bg-light" data-bs-toggle="modal"
                        data-bs-target="#addReveiwModal">
                        Review erstellen
                    </button>
                    <button class="p-3 rounded-4 border bg-light">
                        in die Watchliste
                    </button>
                </div>
            </div>

        </div>
        <br />

        <div class="d-flex justify-content-between">
            <a href='#' class="p-3">Bild ändern </a>
            <a href='#' class="p-3">Beschreibung ändern</a>
        </div>

        <div class="row">
            <div class="col-sm-4 mb-3">
                <div class="panel panel-primary">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="d-flex px-3 justify-content-between">
                                <div class="d-flex ">
                                    <img src="https://image.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600w-1037719192.jpg"
                                        alt="Logo" width="24" height="20" class="rounded-4">
                                    <h6 class="text-start card-title">User-xyz-abc</h6>
                                </div>
                                <h6 class="card-title">Rating: 7.2</h6>
                            </div>

                            <div class="col">
                                <div class="card-block px-2 mx-1" style="max-height: 130px; text-align: justify;">
                                    <p class="card-text truncate-max-5lines">Lorem ipsum dolor sit amet consectetur,
                                        adipisicing elit. Numquam provident sunt ab. Laudantium fuga, odit quae
                                        necessitatibus recusandae perferendis eius harum. Ipsum ut magni corrupti,
                                        nesciunt labore repudiandae sapiente aspernatur! </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- modal -->
        <div class="modal fade" id="addReveiwModal" aria-labelledby="addReviewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <!-- Modal Inhalt -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addReviewLabel">Add New Review</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form action="/page.php">
                            <div class="text-start my-1">
                                <label class="fw-bold" for="reviewRating">Bewertung</label>
                                <input type="number" step="0.1" min="1" max="10" class="form-control w-25 px-3" id="reviewRating"
                                    placeholder="1 - 10" name="reviewRating">
                                
                            </div>
                            <div class="text-start my-1 pt-1">
                                <label class="fw-bold" for="reviewText">Review</label>
                                <textarea type="text" class="form-control text-start" id="reviewText"
                                    placeholder="Enter Review" name="reviewText" style="height:250px;"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-default btn-outline-danger"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Finish</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    
</body>

</html>