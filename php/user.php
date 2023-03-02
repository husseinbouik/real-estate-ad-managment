<?php
session_start();
require 'functions.php';

require 'connect.php';

require 'navbar.php';
// checks if the form with the name "searchbtn" has been submitted 
if (isset($_POST['searchbtn'])) {
    // retrieve the form inputs using $_POST and store them in the $queryParams array   if it's not empty
    if (!empty($_POST['city'])) {

        $city = strtolower($_POST['city']); // capitalize the first letter of each word
        $queryParams[] = "City = '{$city}'";
    }

    if (!empty($_POST['type'])) {
        $queryParams[] = "Type = '{$_POST['type']}'";
    }

    if (!empty($_POST['category'])) {
        $queryParams[] = "Category = '{$_POST['category']}'";
    }

    if (!empty($_POST['max_Price'])) {
        $queryParams[] = "Price <= {$_POST['max_Price']}";
    }

    if (!empty($_POST['min_Price'])) {
        $queryParams[] = "Price >= {$_POST['min_Price']}";
    }




    $filter = ("SELECT * FROM advertisement NATURAL JOIN images_gallery where primary_or_secondary = '1' AND " . implode(" AND ", $queryParams));
    echo $filter;
    // executes the query
    $filter = $conn->query($filter);



} else {

    $pageId;

    if (isset($_GET['pageId'])) {
        $pageId = $_GET['pageId'];
    } else {
        $pageId = 1;
    }

    $endIndex = $pageId * 4;
    $StartIndex = $endIndex - 4;


    $announcesDATA = $conn->query("SELECT  a.*, i.image_path AS primary_image_path FROM advertisement a LEFT JOIN images_gallery i ON a.ad_id = i.ad_id AND i.primary_or_secondary = '1' LIMIT 4 OFFSET $StartIndex")->fetchAll(PDO::FETCH_ASSOC);

    $primaryImagePaths = array();
    foreach ($announcesDATA as $val) {
        $primaryImagePaths[$val['ad_id']] = $val['primary_image_path'];
    }

    $sql = 'SELECT * FROM advertisement';

    // execute a query

    $annoncesLength = $conn->query($sql)->rowCount();

    $pagesNum = 0;

    if (($annoncesLength % 4) == 0) {

        $pagesNum = $annoncesLength / 4;

    } else {

        $pagesNum = ceil($annoncesLength / 4);

    }

}
$city = "SELECT DISTINCT city FROM advertisement";

$citys = $conn->query($city);

if (isset($_POST['date_sort'])) {
    $sort_field = 'publication_date';
    $sort_order = $_POST['date_order'];

    // SQL query to select cards and sort by specified field and order
    $sql = "SELECT * FROM advertisement NATURAL JOIN `images_gallery` where primary_or_secondary = '1' ORDER BY $sort_field $sort_order LIMIT 4 OFFSET $StartIndex";
    $stmt = $conn->query($sql);
    // Fetch the sorted cards
    $sorted = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $page = 'SELECT * FROM advertisement';

    $result = $conn->query($sql);

    $annoncesLength = $conn->query($page)->rowCount();

    $pagesNum = 0;

    if (($annoncesLength % 4) == 0) {

        $pagesNum = $annoncesLength / 4;
    } else {
        $pagesNum = ceil($annoncesLength / 4);
    }
}
if (isset($_POST['price_sort'])) {
    $sort_field = 'price';
    $sort_order = $_POST['price_order'];

    // SQL query to select cards and sort by specified field and order
    $sql = "SELECT * FROM advertisement NATURAL JOIN `images_gallery` where primary_or_secondary = '1' ORDER BY $sort_field $sort_order LIMIT 4 OFFSET $StartIndex";
    $stmt = $conn->query($sql);
    // Fetch the sorted cards
    $sorted = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $page = 'SELECT * FROM advertisement';

    $result = $conn->query($sql);

    $annoncesLength = $conn->query($page)->rowCount();

    $pagesNum = 0;

    if (($annoncesLength % 4) == 0) {

        $pagesNum = $annoncesLength / 4;
    } else {
        $pagesNum = ceil($annoncesLength / 4);
    }
}
?>

<!-- ========== trier  by city and type and categories and price ==========-->

<body>
    <header>
        <div class=" vh-100 w-100 bg-img">
            <div style="padding-top: 9em;" class="d-flex justify-content-center   align-items-center">
                <img src="../img/logoSite.png" alt="logo" loading="lazy" />
            </div>

            <div class=" container  ">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"
                    class="w-100 d-flex justify-content-center  gep-2 mt-5">
                    <label for="" class="d-flex gap-1">
                        <select class="form-select form-select-sm" aria-label=" example" name="city">
                            <option disabled selected>choose City </option>
                            <?php
                            while ($data = $citys->fetch(PDO::FETCH_ASSOC)) {
                                foreach ($data as $city) {
                                    echo "<option value='$city'>$city</option>";
                                }
                            }
                            ?>
                        </select>
                    </label>
                    <label class="d-flex ml-1 gap-2">
                        <select class="form-select form-select-sm" aria-label=" example" name="category">">
                            <option disabled selected>chose category</option>
                            <option value="apartment">Apartment</option>
                            <option value="house">House</option>
                            <option value="villa">Villa</option>
                            <option value="office">Office</option>
                            <option value="land">land</option>
                        </select>
                    </label>
                    <label class="d-flex ml-1 gap-2">
                        <select class="form-select form-select-sm" aria-label=" example" name="type">
                            <option disabled selected>choose type </option>
                            <option value="Rent">Rent</option>
                            <option value="Sale">Sale</option>
                        </select>
                    </label>
                    <label class="d-flex ml-1 gap-2 " id="max-price">
                        <input name="max_Price" type="number" placeholder="Max Price" />
                    </label>
                    <label class="d-flex ml-1 gap-2 " id="min-Price">
                        <input name="min_Price" type="number" placeholder="Min Price" />
                    </label>
                    <button name="searchbtn" type="submit" class="btn btn-warning ml-4">Search</button>
                </form>
            </div>

        </div>
    </header>
    <!-- ================================================== cards affiche ================================================================== -->
    <main>
        <div class=" d-flex gap-2">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <input id="date_order" name="date_order" type="hidden" value="ASC">
                <button id="date_sort" class="btn btn-light" type="submit" name="date_sort">
                    Sort by date <span id="date"><i class="fa-solid fa-sort-up"></i></span>
                </button>
            </form>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <input id="price_order" name="price_order" type="hidden" value="ASC">
                <button id="price_sort" class="btn btn-light" type="submit" name="price_sort">
                    Sort by price <span id="price"><i class="fa-solid fa-sort-up"></i></span>
                </button>
            </form>
        </div>

        <section class="container ">
            <h2 class="d-flex justify-content-center mb-5 mt-5">OUR LAST ANNOUCEMENT</h2>
            <div class="cards">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "GET") { //check if the method is get
                    foreach ($announcesDATA as $key => $val) { //loops in the table of annonce and display the in cards
                        ?>
                        <div class="card border-0  ">
                            <div class="content  w-100 p-0">
                                <a href="details.php?ad_id=<?php echo $val['ad_id']; ?>">
                                    <div class="content-overlay">

                                    </div>
                                    <img class="content-image  " src="../<?php echo $primaryImagePaths[$val['ad_id']]; ?>">
                                    <div class="content-details fadeIn-bottom">
                                        <h3 class="content-title">
                                            <?php echo $val['title']; ?>
                                        </h3>
                                        <p class="content-text">
                                            <?php echo $val['category']; ?>
                                        </p>
                                        <p class="content-text">
                                            <?php echo $val['type']; ?>
                                        </p>
                                        <p class="content-text">
                                            <?php echo $val['price']; ?>
                                        </p>
                                        <p class="content-text">
                                            <?php echo $val['publication_date']; ?>
                                        </p>
                                        <p class="content-text"><i class="fa fa-map-marker"></i>
                                            <?php echo $val['country']; ?>,
                                            <?php echo $val['city']; ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                } else if (isset($_POST['searchbtn'])) { //check if the method is post
                
                    while ($val = $filter->fetch(PDO::FETCH_ASSOC)) {


                        ?>
                            <div class="card ">
                                <div class="content">
                                    <a href="details.php?ad_id=<?php echo $val['ad_id']; ?>">
                                        <div class="content-overlay ">

                                        </div>
                                        <img class="content-image" src="../<?php echo $val['image_path']; ?>">

                                        <div class="content-details fadeIn-bottom">
                                            <h3 class="content-title ">
                                            <?php echo $val['title']; ?>
                                            </h3>
                                            <p class="content-text"><i class="fa fa-map-marker"></i>
                                            <?php echo $val['city'] ?>
                                            </p>
                                            <p>
                                            <?php echo $val['type'] ?>
                                            </p>
                                            <p>
                                            <?php echo $val['price'] ?> DH
                                            </p>
                                            <p>
                                            <?php echo $val['category'] ?>
                                            </p>

                                            <p class="content-text">
                                            <?php echo $val['publication_date']; ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php
                    }
                } elseif (isset($_POST['date_sort'])) {
                    for ($i = 0; $i < count($sorted); $i++) {
                        ?>
                            <div class="card ">
                                <div class="content">
                                    <a href="details.php?ad_id=<?php echo $sorted[$i]['ad_id']; ?>">
                                        <div class="content-overlay ">

                                        </div>
                                        <img class="content-image" src="../<?php echo $sorted[$i]['image_path']; ?>">

                                        <div class="content-details fadeIn-bottom">
                                            <h3 class="content-title ">
                                            <?php echo $sorted[$i]['title']; ?>
                                            </h3>
                                            <p class="content-text"><i class="fa fa-map-marker"></i>
                                            <?php echo $sorted[$i]['city'] ?>
                                            </p>
                                            <p>
                                            <?php echo $sorted[$i]['type'] ?>
                                            </p>
                                            <p>
                                            <?php echo $sorted[$i]['price'] ?> DH
                                            </p>
                                            <p>
                                            <?php echo $sorted[$i]['category'] ?>
                                            </p>
                                            <p class="content-text">
                                            <?php echo $sorted[$i]['publication_date']; ?>
                                            </p>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php
                    }
                } elseif (isset($_POST['price_sort'])) {
                    for ($i = 0; $i < count($sorted); $i++) {
                        ?>
                            <div class="card ">
                                <div class="content">
                                    <a href="details.php?ad_id=<?php echo $sorted[$i]['ad_id']; ?>">
                                        <div class="content-overlay ">

                                        </div>
                                        <img class="content-image" src="../<?php echo $sorted[$i]['image_path']; ?>">

                                        <div class="content-details fadeIn-bottom">
                                            <h4 class="content-title ">
                                            <?php echo $sorted[$i]['title']; ?>
                                            </h4>
                                            <p class="content-text"><i class="fa fa-map-marker"></i>
                                            <?php echo $sorted[$i]['city'] ?>
                                            </p>
                                            <p>
                                            <?php echo $sorted[$i]['type'] ?>
                                            </p>
                                            <p>
                                            <?php echo $sorted[$i]['price'] ?> DH
                                            </p>
                                            <p>
                                            <?php echo $sorted[$i]['category'] ?>
                                            </p>
                                            <p class="content-text">
                                            <?php echo $sorted[$i]['publication_date']; ?>
                                            </p>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php
                    }
                }
                ;
                ?>
            </div>
        </section>
    </main>
    <?php if ($_SERVER["REQUEST_METHOD"] == "GET" || isset($_POST['date_sort']) || isset($_POST['price_sort'])) { ?>
        <nav class="mt-4 mb-4 " aria-label="Page navigation example">
            <ul class=" flex-wrap pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <?php for ($i = 1; $i <= $pagesNum; $i++) { ?>
                    <li class="page-item"><a class="page-link" href="<?php echo "user.php?pageId=" . $i ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    <?php }
    ?>
    </div>

    <script>

        let date_sort = document.getElementById('date_sort') // the date sort button
        let price_sort = document.getElementById('price_sort') // the price sort button
        let price = document.getElementById('price') // the price icone
        let date = document.getElementById('date') // the date icone
        let price_order = document.getElementById('price_order') // price sort order
        let date_order = document.getElementById('date_order') // date sort order
        date_sort.addEventListener('click', function () {
            if (date_order.value == "ASC") {
                date_order.value = "DESC"
                date.innerHTML = `<i class="fa-solid fa-sort-up"></i>`
            } else {
                date_order.value = "ASC"
                date.innerHTML = `<i class="fa-solid fa-sort-down"></i>`
            }
        })
        price_sort.addEventListener('click', function () {
            if (price_order.value == "ASC") {
                price.innerHTML = `<i class="fa-solid fa-sort-up"></i>`
                price_order.value = "DESC"
            } else {
                price_order.value = "ASC"
                price.innerHTML = `<i class="fa-solid fa-sort-down"></i>`
            }
        })
    </script>
    
</body>

</html>