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
<h1>Search tegs</h1>
<h3>Результат по тегу: <?=$ishim ?></h3>

<?php foreach ($searching as $key=>$value): ?>
    <div class="message">
        <div> <?=htmlspecialchars($searching[$key]["mes"]) ?></div>
        <span class="left"><?= htmlspecialchars($searching[$key]["userid"]); ?></span>
        <span class="right"><?= htmlspecialchars($searching[$key]["date"]); ?></span>
        <br>
        <br>
    </div>
<?php endforeach ?>

</body>
</html>