<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>epic blog</title>
    <link rel="stylesheet" href="css\<?= $style ?>.css">
</head>
<body>
<h1>Home</h1>
<?php
foreach ($mesage as $key=>$value){
            echo htmlentities($mesage[$key]["mes"]);
            echo "<br>";
            echo htmlentities($mesage[$key]["userid"])." ".htmlentities($mesage[$key]["date"]);
            echo "<br>";
            echo "<br>";}
?>
<form action ="<?= $homeurl?>" method="post">
    <textarea name="mesagewindow" rows="5"></textarea>
    <input type="submit" name="action" value="save">
    <input type="hidden" name="token" value="<?=$token?>">
</form>
</body>
</html>