<!DOCTYPE html>
<html>
<?php 
session_start();

require('connect.php');



if(isset($_SESSION["user_email"])){
  // echo $_SESSION["user_email"];
  // echo $_SESSION['user_id'];
}

?>

<head>
  <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Italiana&display=swap" rel="stylesheet" />
  <script src="https://code.iconify.design/iconify-icon/1.0.5/iconify-icon.min.js"></script>
  <link rel="stylesheet" href="../css/style_profile.css">
  <script src="https://code.iconify.design/iconify-icon/1.0.3/iconify-icon.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous" defer></script>
  <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet" />
</head>

<body>
<nav class="navbar navbar-expand-lg fixed-top" id="nav">
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarButtonsExample" aria-controls="navbarButtonsExample" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarButtonsExample">
                <!-- Left links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item mr-4">
                        <a class="nav-link text-white" href="user.php">Home</a>
                    </li>
                </ul>
                <div class="btn-group me-3">
    <img class="img-fluid rounded-circle" width="50" src="https://i.stack.imgur.com/YQu5k.png" data-bs-toggle="dropdown" aria-expanded="false" alt="avatar">
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="profile.php">profile</a></li>
        <li><a class="dropdown-item" href="logout.php" name="logout">logout</a></li>
    </ul>
    </div>
    </div>
        </div>
    </nav>
  <?php require('profilinfo.php'); ?>
  <div class="container">
    <div class="addcard d-flex justify-content-center align-items-center"><button class="btn btn-warning mt-3 text-white" data-bs-target="#addModalL" data-bs-toggle="modal">add a new card <iconify-icon icon="material-symbols:add-circle" style="color: white;"></iconify-icon></button></div>
    <div class="allcards d-flex flex-wrap gap-3">
      <?php require('displaycards.php');
      ?>
    </div>
    <!-- Modal add -->
    <div class="modal fade" id="addModalL" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content h-25">
          <div class="modal-body bgmodal">
            <form action="insert.php" method="POST" id="myForm" enctype="multipart/form-data">
              <h2>Ajouter l'anonce</h2>
              <div class="container d-flex gap-2">
              <?php for ($i = 0; $i < 5; $i++) { ?>
        <div class="secondary-image-wrapper file-input d-md-flex flex-column justify-content-center align-items-center mb-3 w-25 h-25 d-flex">
          <img id="icon1<?php echo $i; ?>" src="cloud-upload.svg" alt="Upload Icon" />
          <input type="file" name="images[]" id="fileUpload<?php echo $i; ?>" />
          <img class="previewImage" id="previewImage1<?php echo $i; ?>" src="#" alt="Image Preview" />
        </div>
      <?php }  ?>
</div>


              <div class="d-flex flex-wrap gap-3">
                <div class="mb-3">
                  <label for="exampleFormControlInput0" class="form-label">Titre</label>
                  <input type="text" name="title" class="form-control" id="titleAdd" placeholder="Titre" />
                  <p id="titleError">Veuillez saisir un titre valide.</p>
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlInput0" class="form-label">category</label>
                  <input type="text" name="category" class="form-control" id="titleAdd" placeholder="Titre" />
                  <p id="titleError">Veuillez saisir un category valide.</p>
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Montant</label>
                  <input type="number" min="0" name="price" class="form-control" id="priceAdd" placeholder="Montant" />
                  <p id="priceError">Veuillez saisir un montant valide.</p>
                </div>
                <div class="mb-3">
                  <label for="countryAdd" class="form-label">Country</label>
                  <input type="text" name="country" class="form-control" id="countryAdd" placeholder="Country" />
                  <p id="countryError">Veuillez saisir un pays valide.</p>
                </div>
                <div class="mb-3">
                  <label for="cityAdd" class="form-label">City</label>
                  <input type="text" name="city" class="form-control" id="cityAdd" placeholder="City" />
                  <p id="cityError">Veuillez saisir une ville valide.</p>
                </div>
                <div class="mb-3">
                  <label for="areaAdd" class="form-label">Area</label>
                  <input type="text" name="area" class="form-control" id="areaAdd" placeholder="Area" />
                  <p id="areaError">Veuillez saisir une zone valide.</p>
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Adresse</label>
                  <input type="text" name="address" class="form-control" id="addressAdd" placeholder="Adresse" />
                  <p id="addressError">Veuillez saisir une adresse valide.</p>
                </div>
                <div class="mb-3">
                  <label for="zipCodeAdd" class="form-label">Zip Code</label>
                  <input type="text" name="zipCode" class="form-control" id="zipCodeAdd" placeholder="Zip Code" />
                  <p id="zipCodeError">Veuillez saisir un code postal valide.</p>
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">surface</label>
                  <input type="number" min="0" name="surface" class="form-control" id="superficieAdd" placeholder="Superficie" />
                  <p id="superficieError">Veuillez saisir une superficie valide.</p>
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Type</label>
                  <select class="form-select" name="type" id="typeAdd">
                    <option selected disabled>Choisir</option>
                    <option value="sale">sale</option>
                    <option value="lease">lease</option>
                  </select>
                  <p id="typeError">Veuillez choisir un type.</p>
                </div>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="exampleFormControlTextarea2" rows="3"></textarea>
              </div>
              <div class="justify-content-center d-flex">
                <button name="addBtn" value="addBtn" type="submit" class="btn buttons" id="addBtn">Ajouter</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <script src="../js/index.js"></script>
</body>

</html>