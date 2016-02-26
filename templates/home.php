<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>epic blog</title>
    <link rel="stylesheet" href="css/<?= $style ?>.css">
</head>
<body>
<a href="<?= $homeurl ?>?action=profile">profile</a>
<form action ="<?= $homeurl?>" method="post">
    <input type="submit" name="action" value="Exit">
    <input type="hidden" name="quit" value="true">
    <input type="hidden" name="token" value="<?=$token?>">
</form>
<h3>Поиск по тегам:</h3>
<form action ="<?= $homeurl?>?action=search" method="post">
    <textarea name="Searchtags" rows="1">Search</textarea>
    <input type="submit" name="action" value="search">
    <input type="hidden" name="token" value="<?=$token?>">
</form>

<h3>Количество сообщений на стр.:</h3>
<form action ="<?= $homeurl?>" method="post">
    <input type="submit" name="countmessage" value="3">
    <input type="submit" name="countmessage" value="5">
    <input type="submit" name="countmessage" value="10">
    <input type="hidden" name="token" value="<?=$token?>">
</form>

<h3>Cтраницы:</h3>
<form action ="<?= $homeurl?>" method="post">
<?php for($i=1;$i<=$kolstraniz;$i++):  ?>
    <input type="submit" name="page" value=<?= $i ?>>
    <input type="hidden" name="token" value="<?=$token?>">
<?php endfor ?>
</form>
<h1>Home</h1>

<?php foreach ($mesage as $key=>$value): ?>
<div class="message">
    <?php if ($messEdit==$mesage[$key]["id"]): ?>
        <form action ="<?= $homeurl?>?action=home" method="post">
            <textarea name="mesageEdit" rows="5"><?= $mesage[$key]["mes"] ?></textarea>
            <input type="submit" name="action" value="Save">
            <input type="submit" name="action" value="Cancel">
            <input type="hidden" name="token" value="<?=$token?>">
        </form>
        <?php else: ?>
    <div> <?=htmlspecialchars($mesage[$key]["mes"]) ?></div>
    <span class="left"><?= htmlspecialchars($mesage[$key]["userid"]); ?></span>
    <span class="right"><?= htmlspecialchars($mesage[$key]["date"]); ?></span>
        <form action ="<?= $homeurl?>?action=home" method="post">
            <input type="submit" name="action" value="Delete">
            <input type="submit" name="action" value="Edit">
            <input type="hidden" name="delete" value="<?=$mesage[$key]["id"]?>">
            <input type="hidden" name="token" value="<?=$token?>">
        </form>
    <br>
</div>
<br>
<br>
    <?php endif ?>
<?php endforeach ?>

<form action ="<?= $homeurl?>?action=home" method="post">
    <textarea name="mesagewindow" rows="5"></textarea>
    <br>
    <textarea name="tagswindow" rows="1">tags</textarea> <!-- теги (не обязательно запонять) сообщения через запятую пример: вася, пупкин, Володя, ...-->
    <br>
    <input type="submit" name="action" value="message">
    <input type="hidden" name="token" value="<?=$token?>">
</form>
</body>
</html>