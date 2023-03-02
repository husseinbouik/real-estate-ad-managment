<?php
require('connect.php');

// Prepare and execute the query to fetch ad data 
$user_email = $_SESSION['user_email']; 
$query = "SELECT advertisement.*, images_gallery.*, users.email AS user_email
          FROM advertisement
          INNER JOIN images_gallery ON advertisement.ad_id = images_gallery.ad_id
          INNER JOIN users ON advertisement.user_id = users.user_id
          WHERE users.email = ?";
try {
  $stmt = $conn->prepare($query);
  $stmt->execute([$user_email]);
  $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!$ads) {
    echo "No ads found!";
  }
} catch (PDOException $e) {
  echo 'Query failed: ' . $e->getMessage();
  exit;
}
?>

<?php foreach ($ads as $ad) : if ($ad['primary_or_secondary'] == 1) {  ?>
    <!-- Display the ad data in HTML -->
    <div class="card" style="width: 18rem;">
      <img src="../<?php echo $ad['image_path']; ?>" class="card-img-top" alt="Ad Image">
      <div class="card-body">
        <h5 class="card-title"><?php echo $ad['title']; ?></h5>
        <p class="card-text">Category: <span class="fw-bold"><?php echo $ad['category']; ?></span></p>
        <p class="card-text">Type: <span class="fw-bold"><?php echo $ad['type']; ?></span></p>
        <p class="card-text"><iconify-icon icon="fluent:slide-size-20-regular"></iconify-icon><span class="fw-bold"><?php echo $ad['surface']; ?></span></p>
        <p class="card-text"><iconify-icon icon="material-symbols:location-on"></iconify-icon><span class="fw-bold"><?php echo $ad['city'] . ' ' . $ad['area'] . ' ' . $ad['address']; ?></span></p>
        <p class="card-text">Price: <span class="fw-bold">$<?php echo $ad['price']; ?></span></p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="#" class="btn btn-outline-warning rounded-circle me-md-2" role="button" data-bs-toggle="modal" data-bs-target="#edit<?php echo $ad["ad_id"] ?>"><iconify-icon icon="material-symbols:edit-document-sharp"></iconify-icon></a>
          <a href="#" class="btn btn-outline-danger rounded-circle" data-bs-toggle='modal' data-bs-target="#deletee<?php echo $ad["ad_id"] ?>" role="button" value='<?php echo $ad['ad_id']; ?>'><iconify-icon icon="material-symbols:auto-delete"></iconify-icon></a>
          <a  class="btn btn-primary" role="button" href="details.php?ad_id=<?php echo $ad['ad_id']; ?>">View Details</a>
        </div>
      </div>
    </div>
  <?php } ?>
  <!-- Modal delete -->
  <div class="modal" id="deletee<?php echo $ad["ad_id"] ?>" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content h-25">
        <div class="modal-body texte-white bgmodal">
          <h3>étes vous sure de vouloir supprimer</h3>
          <form method="post" action="delete.php">
            <input type="hidden" name="ad_id" value="<?php echo $ad['ad_id']; ?>" id="delete_id<?php echo $ad['ad_id']; ?>">
            <button type="submit" name="delete">Supprimer</button>
            <button type="button" class="btn btn-secondary buttons" data-bs-dismiss="modal">Annuler</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal edit-->
  <div class="modal fade h-5" id="edit<?php echo $ad["ad_id"] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content h-25">
        <div class="modal-body  bgmodal">
        <form action="update.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="ad_id" value="<?php echo $ad['ad_id']; ?>">
  <div class="container">
    <h2>Modifier l'annonce</h2>
    <div class="container d-flex gap-2">
      <!-- Primary image input field -->
      <div class="secondary-image-wrapper file-input d-md-flex flex-column justify-content-center align-items-center mb-3 w-25  d-flex">
        <img class='icon' id="icon0" src="cloud-upload.svg" alt="Upload Icon" />
        <input type="file" name="image[]" id="fileInput0" />
        <input type="hidden" name="image_id[]" value="<?php echo $ad['image_id']; ?>">
        <img class="previewImages" id="previewImage0" src="../<?php echo $ad['image_path']; ?>" alt="Image Preview" width="100" />
      </div>

      <!-- Secondary image input fields -->
      <?php $id =  $ad["ad_id"]; 
      foreach ($ads as $i => $ad) {
        if ($ad['primary_or_secondary'] == '0' && $ad["ad_id"] == $id) {
      ?>
        <div class="secondary-image-wrapper file-input d-md-flex flex-column justify-content-center align-items-center mb-3 w-25  d-flex">
          <img class='icon' id="icon<?php echo $i + 1; ?>" src="cloud-upload.svg" alt="Upload Icon" />
          <input type="file" name="image[]" id="fileInput<?php echo $i + 1; ?>" />
          <input type="hidden" name="image_id[]" value="<?php echo $ad['image_id']; ?>">
          <img class="previewImages" id="previewImage<?php echo $i + 1; ?>" src="../<?php if ($ad['primary_or_secondary'] == '0') { echo $ad['image_path']; } ?>" alt="Image Preview" width="100" />
        </div>
      <?php }
      } ?>
    </div>
  </div>
            <div class="d-flex flex-wrap gap-3">
              <div class="mb-3">
                <label for="exampleFormControlInput0" class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" id="titleAdd" placeholder="title" value="<?php echo $ad['title']; ?>" />
                <p id="titleError">Veuillez saisir un titre valide.</p>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput0" class="form-label">category</label>
                <input type="text" name="category" class="form-control" id="titleAdd" placeholder="category" value="<?php echo $ad['category']; ?>" />
                <p id="titleError">Veuillez saisir un category valide.</p>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Montant</label>
                <input type="number" min="0" name="price" class="form-control" id="priceAdd" placeholder="price" value="<?php echo $ad['price']; ?>" />
                <p id="priceError">Veuillez saisir un montant valide.</p>
              </div>
              <div class="mb-3">
                <label for="countryAdd" class="form-label">Country</label>
                <input type="text" name="country" class="form-control" id="countryAdd" placeholder="Country" value="<?php echo $ad['country']; ?>" />
                <p id="countryError">Veuillez saisir un pays valide.</p>
              </div>
              <div class="mb-3">
                <label for="cityAdd" class="form-label">City</label>
                <input type="text" name="city" class="form-control" id="cityAdd" placeholder="City" value="<?php echo $ad['city']; ?>" />
                <p id="cityError">Veuillez saisir une ville valide.</p>
              </div>
              <div class="mb-3">
                <label for="areaAdd" class="form-label">Area</label>
                <input type="text" name="area" class="form-control" id="areaAdd" placeholder="Area" value="<?php echo $ad['area']; ?>" />
                <p id="areaError">Veuillez saisir une zone valide.</p>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Adresse</label>
                <input type="text" name="address" class="form-control" id="addressAdd" placeholder="address" value="<?php echo $ad['address']; ?>" />
                <p id="addressError">Veuillez saisir une adresse valide.</p>
              </div>
              <div class="mb-3">
                <label for="zipCodeAdd" class="form-label">Zip Code</label>
                <input type="text" name="zipCode" class="form-control" id="zipCodeAdd" placeholder="Zip Code" value="<?php echo $ad['zip_code']; ?>" />
                <p id="zipCodeError">Veuillez saisir un code postal valide.</p>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">surface</label>
                <input type="number" min="0" name="surface" class="form-control" id="superficieAdd" placeholder="surface" value="<?php echo $ad['surface']; ?>" />
                <p id="superficieError">Veuillez saisir une superficie valide.</p>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Type</label>
                <select class="form-select" name="type" id="typeedit">
                  <option value="lease" <?php if ($ad['type'] == 'lease') {
                                          echo 'selected';
                                        } ?>>lease</option>
                  <option value="sale" <?php if ($ad['type'] == 'sale') {
                                          echo 'selected';
                                        } ?>>sale</option>
                </select>
                <p id="typeError">Veuillez choisir un type.</p>
              </div>
            </div>
            <div class="mb-3">
              <label for="descriptionedit" class="form-label">Description</label>
              <textarea class="form-control" name="description" id="descriptionedit" value=""><?php echo $ad['description']; ?></textarea>
            </div>
            <div class="justify-content-center d-flex">
              <button type="submit" name="updateBtn" value="Update Property" class="btn buttons">
                Modifier
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>