<?php
session_start();

require '../func.php';

$action = empty($_GET['action']) ? 'home' : $_GET['action'];

$pdo=new PDO("mysql:host=127.0.0.1; dbname=epixphp; charset=utf8","root","");

$_COOKIE['style']=123;
$style = 'main';

if (isset($_COOKIE['style'])){
    switch ((int)$_COOKIE ['style']){
        case 1:
            $style= 'black';
            break;
        case 2:
            $style='red';
            break;}
}

$userids=123;
// сделать юсер ид после рег

switch ($action) {
    case 'login':
        echo templates('templates/autoriz.php', [
            'style' => $style,
            'token' => 2,
        ]);
        break;

    case 'profile':
        echo templates('templates/profile.php', [
            'style' => $style,
        ]);
        break;

    default:

        $_POST['mesagewindow'] = htmlentities($_POST['mesagewindow']);

        echo "1111";

        if (($_SESSION['tokens']==$_POST["tokens"])&&(formcheck($_POST['mesagewindow'])==false))
        {
            $selec2 = $pdo->prepare("INSERT into mesage set date=now(), mes=:mess,userid=:uses");
            $selec2->execute([
                ':mess'=>$_POST["mesagewindow"],
                ':uses'=>$userids
            ]);
        }
        elseif (!empty($_SESSION['tokens'])){echo "What are you doing?";}

//     newtoken();
        $start=0;
        $kols=4;
        $selec3=$pdo->query("SELECT mesage.mes, users.login, mesage.date FROM mesage LEFT JOIN users ON mesage.userid=users.id order by mesage.date DESC");

        $selec1=$pdo->prepare("SELECT mesage.mes, users.login, mesage.date FROM mesage LEFT JOIN users ON mesage.userid=users.id order by mesage.date DESC Limit :starts,:counts ");
        $selec1->execute([
           ':starts'=> $start,
           ':counts'=> $kols
        ]);

        $mesages = $selec3->fetchAll();
        var_dump($mesages);

//        for ($i=0; $i<$kols;$i++){
//            $row = $selec1->fetch(PDO::FETCH_ASSOC);
//            echo htmlentities($row["mes"]);
//            var_dump($row);
//            echo "<br>";
//            echo htmlentities($row["login"])." ".htmlentities($row["date"]);
//            echo "<br>";
//            echo "<br>";
//        }
//        echo "</br>";

        echo templates('templates/home.php', [
             'token' => newtoken(),
             'style' => $style,
             'mesage'=> $mesages,
        ]);
        break;
}
