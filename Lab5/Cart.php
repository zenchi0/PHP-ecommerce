<?php
include_once 'homePage.php';
session_start();
//Cart variables
$productID = $_POST['productID'];
$productImageURL = $_POST['productImageURL'];
$productName = $_POST['productName'];
$quantity = $_POST['quantity'];
$productPrice = $_POST['productPrice'];
$totalCost = $productPrice * $quantity;
if (isset($_POST['addProd'])) {
    $_SESSION['cart'][$productID] = array($productImageURL, $productName,
                                          $quantity, $productPrice, $totalCost);
    $_SESSION['cart']['TotalPrice'] += $totalCost;
    //prompt
    $actionWords = "loaded into";
}
if (isset($_POST['removeProd'])) {
    $_SESSION['cart']['TotalPrice'] -= $totalCost;
    unset($_SESSION['cart'][$productID]);
    //prompt
    $actionWords = "removed from";
}
//Markup variables
$heading = "The mobile phone has been $actionWords the basket!";
$para = "Continue shopping <a href='./products.php'>here.</a><br />" .
        "Ready to <a href='./order.php'>checkout?</a>";
$img = "./images/ZenWireless.jpg";
//Create the page
homePage($heading, $para, $img);
?>
