<?php 
 session_start();
 include 'config/database.php';
 include 'controller/SellerController.php';
 include 'model/SellerModel.php';
 $SellerController = new SellerController($db,new SellerModel($db));
 $currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
 $pageTitle = 'Create a Product';
 $item = [['title'=>"",'price'=>"",'quantity'=>"",'userreview'=>"",'description'=>""]];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    echo $_FILES['product-img']['name'];
    $imageName="";
    # first saving the product-img if sended
    if (isset($_FILES["product-img"]) && $_FILES["product-img"]["error"] == 0) {
        // Define a directory where you want to save the uploaded product-img
        $uploadDirectory = "image/product/";

        // Create the directory if it doesn't exist
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        // Get the temporary file name
        $tempFileName = $_FILES["product-img"]["tmp_name"];

        // Generate a unique name for the product-img to avoid overwriting existing files
        $imageName = uniqid() . "_" . $_FILES["product-img"]["name"];

        // Define the full path where the product-img will be saved
        $targetFilePath = $uploadDirectory . $imageName;

        // Move the uploaded product-img to the target location
        if (move_uploaded_file($tempFileName, $targetFilePath)) {
            // echo "product-img uploaded successfully. File saved as: " . $targetFilePath;
        } else {
            // echo "Error uploading product-img.";
        }
    } else {
        // echo "Error: " . $_FILES["product-img"]["error"];
    }
   
  
    #storing the data to the database 
    
    # storing the updated data in the database
    $data = array('title'=>$_POST['title'],'description'=>$_POST['about'],'quantity'=>$_POST['stock'],'price'=>$_POST['price'],'img'=>$imageName);
    $result = $SellerController->addProduct($_SESSION['username'],$_SESSION['user_type'],$data);
    // $SellerController->updateProduct();
    if($result['flag'] == true){
        #insert data into the stripe 
    echo $result['productid'];
    require_once 'vendor/autoload.php';
    \Stripe\Stripe::setApiKey('sk_test_51MrFV1SFr8gJHZSEpyH8wYu6dBwbcR67JOMKWf7z7nsnMfb9Kjifnbn7m37NuozooTuXPe6Xb8efyPAVYu7EFG3500m9hId0zi');
    try {
        // Create a new product
        $product = \Stripe\Product::create([
            'name' => $data['title'],      // Replace with your product name
            'description' => $data['description'],
            'images' => ["image/product/$imageName"],
            // Replace with your product description
            // Optional metadata
        ]);
    
        // Access the product's ID
        $product_id = $product->id;
        $price = \Stripe\Price::create([
            'unit_amount' => $data['price']*100, // The price amount in cents (e.g., $10.00)
            'currency' => 'inr', // The currency code (e.g., USD)
            'product' => $product_id, // ID of the product this price is associated with
             // Absolute URL to the image
        ]);
        $price_id = $price->id;
        echo "Product created successfully with ID: " . $product_id;
        echo "Product created successfully with ID: " . $price_id; 
        $stripeData = array('product_id'=>$product_id,'price_id'=>$price_id,'productid'=>$result['productid']);
        # update product set product id and price id 
        $SellerController->updateProduct($_SESSION['username'],$_SESSION['user_type'],$stripeData);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Handle any errors that occur during the creation
        echo 'Error: ' . $e->getMessage();
    }

    //    $result = $UserController->updateSellerProduct($id);
    //    echo "$result";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam</title>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body style="height: 100vh;">
    <?php include('partials/adminUpdate.php') ?>
</body>
</html>