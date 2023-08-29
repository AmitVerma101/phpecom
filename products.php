<?php 
    session_start();
    include 'config/database.php';
    include 'controller/ProductController.php';
    include 'model/ProductModel.php';
    
    $moreProductsArray = [];
    $ProductController = new ProductController($db,new ProductModel($db));
    $pagination ;
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $_SESSION['pagination'] = 0;
        $pagination = $_SESSION['pagination'];
        $resultArray = $ProductController->fetchInitialProducts($pagination);

    }
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $_SESSION['pagination'] = $_SESSION['pagination']+1;
        $pagination = $_SESSION['pagination'];
        $moreProductsArray = $ProductController->fetchInitialProducts($pagination);  
          foreach ($moreProductsArray as $item) {
                include 'partials/items.php';
             }     
        exit;  
    }
   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam/Product</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/product.css">
</head> 
<body>
    <?php include 'partials/header.php' ; ?>
    
    <div class="main-body">
        <h1 id="title">FREE TO PLAY GAMES</h1>
        <div id="featured-game-div">
            <h3 id="featured-game-title">Featured Game</h3>
            <div id="featured-game">
                <img class="game-img" src="image/product/header.jpg">
                <div class="game-info">
                    <div class="background-img-cover">
                    </div>
                    <div class="game-title-text">
                        <h4>Goose Goose Duck</h4>
                        <p>Oct 4, 2021</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="item-container" class="flex-column">
            <h4>Game List</h4>
  
           <?php 
            foreach ($resultArray as $item) {
                include 'partials/items.php';
             }
            

           ?>
            <button id="show-more">Show More</button>
        </div>
    </div>
    <div>
    </div>
    <footer>
    </footer>
</body>
<script src="javascript/product.js" type="module"></script>
</html>
