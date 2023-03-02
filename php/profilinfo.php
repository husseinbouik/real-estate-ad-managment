<?php
require('connect.php');

$user_email = $_SESSION["user_email"];
$sql = "SELECT first_name, last_name, phone_number, email, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_email]);


if ($stmt->rowCount() > 0) {
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $first_name = $row["first_name"];
  $last_name = $row["last_name"];
  $phone_number = $row["phone_number"];
  $email = $row["email"];
  $password = $row["password"];

  // Replace HB with the user's initials
  $initials = strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1));
} else {
  echo "User not found.";
}

?>
  <!-- Display user's information using HTML code -->
  <div class="profilinfo d-flex gap-5 " style="height: 320px; padding: 0%; margin-top:89px;">
    <div class="rounded-circle bg-dark d-flex justify-content-center align-items-center" style="width: 150px; height: 150px;margin-top:89px;margin-left:89px;">
      <span class="text-white display-1 font-weight-bold"><?php echo $initials; ?></span>
    </div>
    <div class="userinfo bg-light p-4 rounded w-50 ">
      <p class="card-text">First name: <span class="fw-bold"><?php echo  $row["first_name"]; ?></span></p>
      <p class="card-text">Last name: <span class="fw-bold"><?php echo $row["last_name"]; ?></span></p>
      <p class="card-text">Phone number: <span class="fw-bold"><?php echo $row["phone_number"];; ?></span></p>
      <p class="card-text">Email: <span class="fw-bold"><?php echo $row["email"]; ?></span></p>
      <p class="card-text">Password: <span class="fw-bold"><?php echo $row["password"]; ?></span></p>
      <div class="editprofil"><button  type="button" class="btn btn-secondary mt-3" data-bs-toggle="modal" data-bs-target="#editModal" >Edit <iconify-icon icon="material-symbols:edit"></iconify-icon></button></div>
    </div>
  </div>
  <!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit User Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="editprofilinfo.php" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo$row["first_name"]; ?>">
          </div>
          <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $row["last_name"]; ?>">
          </div>
          <div class="mb-3">
            <label for="phoneNumber" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php echo $row["phone_number"]; ?>">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row["email"]; ?>">
          </div>
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" name="currentPassword">
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword">
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
          </div>
          <input type="hidden" name="userId" value="<?php echo $user_id; ?>">
          <button type="submit" class="btn btn-primary" name="editUser">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

