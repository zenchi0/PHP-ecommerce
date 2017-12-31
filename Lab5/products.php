<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type: image/png" content="text/html;charset=UTF-8">
    <title>ZenWireLess</title>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/form.css" />
    <link rel="stylesheet" href="./css/table.css" />
</head>
<body>
    <?php
    include 'nav_bar.php';
    $currentFile = basename(__FILE__);
    $fileNum = "Lab5";
    createPageNavBar($currentFile, $fileNum)
    ?>
    <div class="ice">
        <section>
      <h1 class="title">Products</h1>
            <p class="intro">
                Below you will find our twelve most popular products.
            </p>
            <?php
                session_start();
                $tableHeaders = array("Product Image", "Name", "Description", "Price", "Add to Cart");
                $tableCaption = "Our Amazing Deals";
                $productFile = "./products.csv";
                csvTable($productFile, $tableCaption, $tableHeaders);
            ?>
        </section>
    </div>
</body>
</html>
<?php
function csvTable($fileName, $caption, $tableHeaders, $currentCartOnly=false)
{
    $dataFile;
    if ($dataFile = validateFile($fileName)) {
        drawTable($dataFile, $caption, $tableHeaders, $currentCartOnly);
    } else {
        echo "<p class='error intro'>";
        echo "Unable to access data file. Please contact site administrator.";
        echo "</p>";
    }
}
function validateFile($fileName)
{
    $dataFile;
    if (!(file_exists($fileName))) {
        return false;
    } elseif (!($dataFile = fopen($fileName, "rb"))) {
        return false;
    } else {
        return $dataFile;
    }
}
function drawTable($dataFile, $caption="", $tableHeaders, $currentCartOnly)
{
    session_start();
    include_once 'DisplayForms.php';
    echo "<table>\n";
    if ($caption != "") {
        echo "<caption>$caption</caption>";
    }
    echo "\t<tr>\n";
    foreach ($tableHeaders as $header) {
        echo "\t\t<th>$header</th>\n";
    }
    echo "\t</tr>\n";
    while ($line = fgetcsv($dataFile)) {
        $productID = $line[0];
        $productImageURL = $line[1];
        $productName = $line[2];
        $productPrice = $line[4];
        echo "\t<tr>\n";
        foreach ($line as $key => $value) {
            if ((substr($value, 0, 4) === "prod")) {
                continue;
            } elseif ((substr($value, -4) === ".jpg")) {
                echo "\t\t<td><img src='$value' title='".$line[$key + 1]."'></td>\n";
            } elseif (is_numeric($value)) {
                echo "<td>";
                echo '$'.number_format($value, 2,'.', ',');
                echo "</td>";
            } else {
                echo "\t\t<td>$value</td>\n";
            }
        }
        if (!isset($_SESSION['username'])) {
            echo "\t\t<td>\n";
            echo "\t\t\t<a href='Login.php'>Login to access the cart.</a>\n";
            echo "\t\t</td>\n";
        } else {
            cartBtn($productID, $productImageURL, $productName, $productPrice, $totalCost);
        }
        echo "\t</tr>\n";
    }
echo "</table>\n";
}
function cartBtn($productID, $productImageURL, $productName, $productPrice, $totalCost)
{
    session_start();
    $inCart = false;
        foreach ($_SESSION['cart'] as $product => $value) {
            if ($product == $productID) {
                $inCart = true;
                $prodQuant = $value[2];
            }
        }
    // }
    if ($inCart === true) {
        removeCartButton($productID, $prodQuant, $productPrice);
    } else {
        addCartBtn($productID, $productImageURL, $productName, $productPrice, $totalCost);
    }
}
function removeCartButton($productID, $quantity, $productPrice)
{
    echo "\t\t<td>\n";
    echo "\t\t\t<form class='tableForm' action='Cart.php' method='post'>\n";
    echo "\t\t\t<p>\n";
    echo "\t\t\t<label for='removeFromCart'>".$quantity." in Cart</label>\n";
    echo "\t\t\t</p>\n";
    echo "\t\t\t<p>\n";
    echo "\t\t\t<input type='hidden' name='productID' value='$productID'>\n";
    echo "\t\t\t<input type='hidden' name='productPrice' value='$productPrice'>\n";
    echo "\t\t\t<input type='hidden' name='quantity' value='$quantity'>\n";
    echo "\t\t\t<input type='hidden' name='removeProd'>\n";
    echo "\t\t\t<input type='image' src='./images/RemoveFromBasket.jpg' ".
                 "name='removeFromCart' title='Remove from Cart'>\n";
    echo "\t\t\t</p>\n";
    echo "\t\t\t</form>\n";
    echo "\t\t</td>\n";
}
function addCartBtn($productID, $productImageURL, $productName, $productPrice)
{
    echo "\t\t<td>\n";
    echo "\t\t\t<form class='tableForm' action='Cart.php' method='post'>\n";
    echo "\t\t\t<p>\n";
    echo "\t\t\t<input type='number' name='quantity' min='1' max='10' value='1'>\n";
    echo "\t\t\t<input type='hidden' name='productID' value='$productID'>\n";
    echo "\t\t\t<input type='hidden' name='productImageURL' value='$productImageURL'>\n";
    echo "\t\t\t<input type='hidden' name='productName' value='$productName'>\n";
    echo "\t\t\t<input type='hidden' name='productPrice' value='$productPrice'>\n";
    echo "\t\t\t<input type='hidden' name='addProd'>\n";
    echo "\t\t\t<input type='image' src='./images/AddToBasket.jpg' ".
                 "name='addToCart' title='Add to Cart'>\n";
    echo "\t\t\t</p>\n";
    echo "\t\t\t</form>\n";
    echo "\t\t</td>\n";
}
?>
