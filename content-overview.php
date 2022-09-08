<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Übersicht</title>
    <link href="css/content-overview.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">    
<button type="button" class="btn btn-info btn-lg my-2" data-bs-toggle="modal" data-bs-target="#addContentModal">Add New Content</button>
  
      <!-- Modal -->
      <div class="modal fade" id="addContentModal" aria-labelledby="addContentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal Inhalt -->
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="addContentLabel">Add New Content</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Name, description, image(file picker) -->
                
                    <form action="/page.php">
                        <div class="form-group my-3">
                            <label for="contentName">Content Name</label>
                            <input type="text" class="form-control" id="contentName" placeholder="Enter content name" name="contentName">
                        </div>
                        <div class="form-group my-3">
                            <label for="contentDescription">Content description</label>
                            <input type="text" class="form-control" id="contentDescription" placeholder="Enter description" name="contentDescription">
                        </div>
                        <div class="form-group my-3">
                            <label for="contentImg" class="form-label">Content Image</label>
                            <input class="form-control" type="file" id="contentImg">
                        </div>
                    </form>
                </div>
                <div class="modal-footer gap-2">
                  <button type="button" class="btn btn-default btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Finish</button>
                </div>
            </div>
        </div>
    </div>
  
  <div class="row" >

    <div class="col-sm-4 mb-3"> 
      <div class="panel panel-primary">
        <div class="card">
          <div class="row no-gutters">
            <div class="col-auto text-center">
              <h4 class="card-title">Title</h4>
              <img src="https://image.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600w-1037719192.jpg" class="img-fluid" alt="">
            </div>
            <div class="col">
              <div class="card-block px-2 mx-1" style="max-height: 110px; text-align: justify;">
                <p class="card-text truncate-max-3lines">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam provident sunt ab. Laudantium fuga, odit quae necessitatibus recusandae perferendis eius harum. Ipsum ut magni corrupti, nesciunt labore repudiandae sapiente aspernatur!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-4 mb-3"> 
      <div class="panel panel-primary">
        <div class="card">
          <div class="row no-gutters">
            <div class="col-auto text-center">
              <h4 class="card-title">Title</h4>
              <img src="https://image.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600w-1037719192.jpg" class="img-fluid" alt="">
            </div>
            <div class="col">
              <div class="card-block px-2 mx-1" style="max-height: 110px; text-align: justify;">
                <p class="card-text truncate-max-3lines">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam provident sunt ab. Laudantium fuga, odit quae necessitatibus recusandae perferendis eius harum. Ipsum ut magni corrupti, nesciunt labore repudiandae sapiente aspernatur!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-4 mb-3"> 
      <div class="panel panel-primary">
        <div class="card">
          <div class="row no-gutters">
            <div class="col-auto text-center">
              <h4 class="card-title">Title</h4>
              <img src="https://image.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600w-1037719192.jpg" class="img-fluid" alt="">
            </div>
            <div class="col">
              <div class="card-block px-2 mx-1" style="max-height: 110px; text-align: justify;">
                <p class="card-text truncate-max-3lines">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam provident sunt ab. Laudantium fuga, odit quae necessitatibus recusandae perferendis eius harum. Ipsum ut magni corrupti, nesciunt labore repudiandae sapiente aspernatur!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="row mt-5 mb-2">

    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="card">
          <div class="row no-gutters">
            <div class="col-auto text-center">
              <h4 class="card-title">Title</h4>
              <img src="https://image.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600w-1037719192.jpg" class="img-fluid" alt="">
            </div>
            <div class="col">
              <div class="card-block px-2 mx-1" style="max-height: 110px; text-align: justify;">
                <p class="card-text truncate-max-3lines">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam provident sunt ab. Laudantium fuga, odit quae necessitatibus recusandae perferendis eius harum. Ipsum ut magni corrupti, nesciunt labore repudiandae sapiente aspernatur!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="card">
          <div class="row no-gutters">
            <div class="col-auto text-center">
              <h4 class="card-title">Title</h4>
              <img src="https://image.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600w-1037719192.jpg" class="img-fluid" alt="">
            </div>
            <div class="col">
              <div class="card-block px-2 mx-1" style="max-height: 110px; text-align: justify;">
                <p class="card-text truncate-max-3lines">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam provident sunt ab. Laudantium fuga, odit quae necessitatibus recusandae perferendis eius harum. Ipsum ut magni corrupti, nesciunt labore repudiandae sapiente aspernatur!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="card">
          <div class="row no-gutters">
            <div class="col-auto text-center">
              <h4 class="card-title">Title</h4>
              <img src="https://image.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600w-1037719192.jpg" class="img-fluid" alt="">
            </div>
            <div class="col">
              <div class="card-block px-2 mx-1" style="max-height: 110px; text-align: justify;">
                <p class="card-text truncate-max-3lines">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam provident sunt ab. Laudantium fuga, odit quae necessitatibus recusandae perferendis eius harum. Ipsum ut magni corrupti, nesciunt labore repudiandae sapiente aspernatur!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div><br>



    
</body>
</html>