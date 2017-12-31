<?php
function homePage($heading, $para, $img)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>ZenWireLess</title>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/form.css" />
    <link rel="stylesheet" href="./css/table.css" />
</head>
<body>
    <?php
    require_once 'nav_bar.php';
    $currentFile = basename(__FILE__);
    $fileNum = "Lab5";
    createPageNavBar($currentFile, $fileNum)
    ?>
    <div class="ice">
        <section>
            <h1 class="title"><?php echo($heading . "<br>"); ?></h1>
		<?php echo ("<center><img src='$img'></center>"); ?>
            <p class="intro">
                <?php echo($para); ?>
            </p>
        </section>
    </div>
</body>
</html>
<?php
}
?>
