<?php
session_start();
include("functions.php");
$no_result   = false;

$dest_path="dest/";
$web_path="/dest/";

$image_dir_iterator = new DirectoryIterator($dest_path);
$imageDirs = [];
$tableauimage = array();

$selectDir = isset($_GET['dir']) ? $_GET['dir'] : null;
//if(isset($_GET['date'])){
//    $selectDir = $_GET['date'];
//    $_SESSION['dir']=$selectDir;
//}elseif(isset($_SESSION['dir'])){
//    $selectDir = $_SESSION['dir'];
//}
//if(isset($_GET['date'])){
//    $selectDir=null;
//}

foreach ($image_dir_iterator as $file) {
    if ($file->isDir()) {
        if (in_array($file->getFilename(), ['.','..'])) continue;
        $imageDirs[] = $file->getFilename();
    }
}
if ($selectDir != null) {
    $image_iterator = new DirectoryIterator($dest_path.$selectDir.'/');
    foreach ($image_iterator as $file) {
        $s = ($file->getExtension());
        if ($s == "jpg") {
            $tableauimage[] = $file->getFileName();
        }
    }
}
if (isset($_GET['date'])) {

    $date        = date("d-m-Y", strtotime($_GET['date']));
    $tabFiltered = [];
    foreach ($imageDirs as $dir) {
        if (preg_match('/' . $date . '/', $dir) != 0) {
            $tabFiltered[] = $dir;
        }
    }

    if (sizeof($tabFiltered) == 0 && isset($_GET['date']) && !empty($_GET['date'])) {
        $no_result = true;
    } else {
        $no_result    = false;
        if (isset($_GET['date']) && !empty($_GET['date'])) {
            $imageDirs = $tabFiltered;
        }
    }

}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Projet tut</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="sticky-footer-navbar.css" rel="stylesheet">
    <link href="assets/css/photoswipe/photoswipe.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">Projet tut</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
<!--                <li class="nav-item active">-->
<!--                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="#">Link</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link disabled" href="#">Disabled</a>-->
<!--                </li>-->
            </ul>
            <form class="form-inline mt-2 mt-md-0" method="get" action="index.php">
                <input class="form-control mr-sm-2" type="date" value="<?php if (isset($_GET['date'])) {echo $_GET['date'];}?>"
                       name="date" placeholder="Search" aria-label="Search">
                <input type="submit" value="Recherche">
            </form>
        </div>
    </nav>
</header>

<!-- Begin page content -->
<main role="main" class="container">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="mt-5"></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <?php if ($no_result) {?>
                        <a href="#" class="list-group-item list-group-item-action disabled">Pas de Résultat</a>
                    <?php } else {?>
                    <?php foreach ($imageDirs as $imageDir) {?>
                        <a href="index.php?dir=<?php echo $imageDir; if(isset($_GET['date'])) echo '&date='.$_GET['date'];?>"
                           class="list-group-item list-group-item-action <?php if($selectDir == $imageDir) echo 'active'; ?>">
                            <?php echo $imageDir; ?>
                        </a>
                    <?php } ?>

                    <?php } ?>
                </div>
            </div>
            <div class="col-md-9">
                <?php if ($selectDir != null) { ?>
                    <div class="row">
                        <?php
                            foreach ($tableauimage as $dir) {?>
                                <div class="col-xs-12 col-md-3">
                                    <div class="card">
                                        <img src="<?php echo $web_path.$selectDir.'/'.$dir; ?> " width=100% alt=""
                                             class="card-img-top imageViewer"
                                             data-href="<?php echo $web_path.$selectDir.'/'.$dir; ?>" data-index="true"
                                             data-size="<?php echo getSize(realpath($dest_path.$selectDir.'/'.$dir)); ?>"
                                        />
                                        <div class="card-body">
                                            <div class="card-title">
                                                <?php echo $dir; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                <?php } else {?>
                    <p>Selectionez un dossier</p>
                <?php } ?>
            </div>
        </div>

    </div>

</main>

<footer class="footer">
    <div class="container">
        <br />
    </div>
</footer>

<?php
echo file_get_contents("photoswip.html");

?>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="../../../../assets/js/vendor/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/photoswipe/photoswipe.js"></script>
<script src="assets/js/photoswipe/photoswipe-ui-default.js"></script>
<script src="assets/js/imageViewer.js"></script>
</body>
</html>
