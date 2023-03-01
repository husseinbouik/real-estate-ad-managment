
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!-- font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Changa:wght@200;400;500;700&display=swap" rel="stylesheet">
    <!-- icon -->
    <script src="https://kit.fontawesome.com/c0019a3c9b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/home.css">
    <title>Document</title>
</head>

<body>


    <header>
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
                        <a class="nav-link text-white" href="guest.php">Home</a>
                    </li>
                </ul>
                
    <?php if(!authenticated()){ ?>
    <a href='Account.php' class="btn btn-outline-warning p-2 m-2" > Sign Up </a>
    <a href='Account.php' class="btn btn-warning p-2 m-2"> Log In </a>
    <?php  
    } else { 
    ?>

    <div class="btn-group me-3">
    <img class="img-fluid rounded-circle" width="50" src="https://i.stack.imgur.com/YQu5k.png" data-bs-toggle="dropdown" aria-expanded="false" alt="avatar">
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="profile.php">profile</a></li>
        <li><a class="dropdown-item" href="logout.php" name="logout">logout</a></li>
    </ul>
    </div>
    <?php } ?>
            </div>
        </div>
    </nav>