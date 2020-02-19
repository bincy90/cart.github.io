<?php

session_start();
require_once ("php/CreateDb.php");
require_once ("php/component.php");
$db=new CreateDb("productdb","producttb");
if(isset($_POST['remove'])){
   //print_r($_GET['id']);
    if($_GET['action']=='remove'){
        foreach ($_SESSION['cart'] as $key=>$value){
            if($value['product_id']==$_GET['id']){
                unset($_SESSION['cart'][$key]);
                echo "<script> alert('Product has been removed...!')</script>";
                echo "<script> window.location='cart.php' </script>";
            }
        }
    }
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js" integrity="sha256-MAgcygDRahs+F/Nk5Vz387whB4kSK9NXlDN3w58LLq0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<?php
require_once ('php/header.php');
?>

<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart">
                <h6>My Cart</h6>
                <hr>
                <?php
                $total=0;
                if(isset($_SESSION['cart'])){
                    $product_id=array_column($_SESSION['cart'],'product_id');
                    $result=$db->getData();
                    while ($row=mysqli_fetch_assoc($result)){
                        foreach ($product_id as $id){
                            if ($row['id']==$id){
                                cartElement($row['product_image'],$row['product_name'],$row['product_price'],$row['id']);
                                $total=$total+(int)$row['product_price'];
                            }
                        }
                    }
                }else{
                    echo "<h5>Cart is Empty</h5>";
                }
                ?>

            </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
            <div class="pt-4">
                <h6>PRICE DETAILS</h6>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                        if (isset($_SESSION['cart'])){
                            $count=count($_SESSION['cart']);
                            echo "<h6>Price($count items) </h6>";
                        }else{
                            echo "<h6>Price(0 items) </h6>";
                        }
                        ?>
                        <h6>Delivery Charges</h6>
                        <hr>
                        <h6>Amount Payable</h6>
                        <script
                            src="https://www.paypal.com/sdk/js?client-id=AZvMRlWU707s9ItNWHUaIWr7iiToac1sbim3fw_fxe3-Y9WOJCPmiH8ljv13H43H1WmUfvkEoM5LPpCM"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
                        </script>
                        <div id="paypal-button-container"></div>

                        <script>
                            paypal.Buttons().render('#paypal-button-container');
                            // This function displays Smart Payment Buttons on your web page.
                        </script>


                    </div>
                    <div class="col-md-6">
                        <h6>$ <?php  echo $total ;?>  </h6>
                        <h6 class="text-success">Free</h6>
                        <hr>
                        <h6>$ <?php
                            echo $total;
                            ?> </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
