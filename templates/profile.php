<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>epic blog</title>
    <link rel="stylesheet" href="css/<?= $style ?>.css">
</head>
<body>
<a href="<?= $homeurl ?>?action=home">home</a>

<form action ="<?= $homeurl?>" method="post">
    <input type="submit" name="action" value="Exit">
    <input type="hidden" name="quit" value="true">
    <input type="hidden" name="token" value="<?=$token?>">
</form>

<h1>profile</h1>
<form action="<?= $homeurl?>?action=profile" method="post">
    <input type="radio" name="style" value="9999999">default<Br>
    <input type="radio" name="style" value="1">black<Br>
    <input type="radio" name="style" value="2">red<Br>
    <input type="submit" name="action" value="profile">
    <input type="hidden" name="token" value="<?=$token?>">
</body>
</html>