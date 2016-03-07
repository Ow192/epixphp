<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Epic blog</title>
    <link rel="stylesheet" href="css/<?= $style ?>.css">
    <base href="http://127.0.0.1/blokepix/block/public/index.php">
</head>
<body>
<header>
<h1>Welcome epix blog</h1>
</header>

<hr>

ddd<strong>ddd</strong><br>
ddd<b>ddd</b>

<hr>

<br>
<?php echo $error;?>
<form action="<?= $homeurl?>?action=login" method="post">
<fieldset class="center">
    <legend>Authorization</legend>
    <input type="text" name="login" placeholder="login" title="login">
    <input type="password" name="password" placeholder="password" title="password">
    <input type="submit" name="action" value="Login">
    <input type="submit" name="action" value="Registration">
    <input type="hidden" name="token" value="<?= $token; ?>">
</fieldset>
</form>
</body>
</html>
