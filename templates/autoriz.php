<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>epic blog</title>
    <link rel="stylesheet" href="assets/<?= $style ?>.css">
</head>
<body>
<h1>autor</h1>
<br>
<h1><?php echo $error;?></h1>
<form action="<?= $homeurl?>" method="post">
    <input type="text" name="login" value="text" title="login">
    <input type="password" name="password" title="password">
    <input type="submit" name="action" value="login">
    <input type="hidden" name="token" value="<?= $token; ?>">
</form>
</body>
</html>
