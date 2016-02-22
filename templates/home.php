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
foreach ($mesages as $key=>$value){
            echo htmlentities($mesages[$key]["mes"]);
            echo "<br>";
            echo htmlentities($mesages[$key]["login"])." ".htmlentities($mesages[$key]["date"]);
            echo "<br>";
            echo "<br>";
}
?>
<form action ="?action=home" method="post">
    <textarea name="mesagewindow" rows="5"></textarea>
    <input type="submit" name="action" value="save">
    <input type="hidden" name="tokens" value=<?=$token?>>
</form>
</body>
</html>