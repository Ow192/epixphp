<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>epic blog</title>
    <link rel="stylesheet" href="assets/<?= $style ?>.css">
</head>
<body>
<h1>profile</h1>
<form action="?action=profile" method="post">
    <input type="radio" name="style" value="0" <?= $style == 'main' ? 'checked' : '' ?>>default<Br>
    <input type="radio" name="style" value="1" <?= $style == 'black' ? 'checked' : '' ?>>black<Br>
    <input type="radio" name="style" value="2" <?= $style == 'red' ? 'checked' : '' ?>>red<Br>
    <input type="submit" name="action" value="profile">
</body>
</html>