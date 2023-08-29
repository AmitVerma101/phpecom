<?php
    
    session_start();
    $pageTitle = 'Update Product';
   
    include 'config/database.php';
    include 'controller/SellerController.php';
    include 'model/SellerModel.php';
    $SellerController = new SellerController($db,new SellerModel($db));
    $id = $_GET['id'];
    
       $item = $SellerController->getProductDetails($id);
        # fetch the details of the existing product 
      
       
        $currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            echo "me phle chluga";
           echo "
           <!DOCTYPE html>
            <html lang=\"en\">
            <head>
                <meta charset=\"UTF-8\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <title>Steam</title>
                <link rel=\"stylesheet\" href=\"css/general.css\">
                <link rel=\"stylesheet\" href=\"css/admin.css\">
            </head>
            <body style=\"height: 100vh;\">
            ";
            include('partials/adminUpdate.php'); 
            echo "</body>
                </html>
           
           
           ";
        
    

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
       
      
        # storing the updated data in the database
        $data = array('productid'=>$id,'title'=>$_POST['title'],'description'=>$_POST['about'],'quantity'=>$_POST['stock'],'price'=>$_POST['price'],'img'=>$imageName);
        #update product data into the database
        $result =  $SellerController->updateSellerProduct($_SESSION['username'],$_SESSION['user_type'],$data);
        // $UserController->updateProduct();
        require_once 'vendor/autoload.php';
        $stripe = new \Stripe\StripeClient('sk_test_51MrFV1SFr8gJHZSEpyH8wYu6dBwbcR67JOMKWf7z7nsnMfb9Kjifnbn7m37NuozooTuXPe6Xb8efyPAVYu7EFG3500m9hId0zi');
        try {
            #updating product

           $product = $stripe->products->update($result['stripe_product_id'], ['name' => $data['title'],'description'=>$data['description'],'images'=>["image/product/$imageName"]]);


           #creating a new price
           $price = $stripe->prices->create([
                'product' => $result['stripe_product_id'],
                'unit_amount' => $data['price']*100,
                'currency' => 'inr',
                
              ]);
            #archiving the current price id
            $stripe->prices->update(
                $result['stripe_price_id'],
                [
                  
                  'active' => false,
                ]
              );
              echo 'new price id'.$price->id;
              $stripeData = array('product_id'=>$product->id,'price_id'=>$price->id,'productid'=>$id);
              # update product set product id and price id 
              $SellerController->updateProduct($_SESSION['username'],$_SESSION['user_type'],$stripeData);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle any errors that occur during the creation
            echo 'Error: ' . $e->getMessage();
        }

        //    $result = $UserController->updateSellerProduct($id);
        //    echo "$result";

    }
    

?>

