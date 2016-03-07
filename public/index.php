<?php

session_start();

require '../config/config.php';
require '../func.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);

$pdo=connect(['host'=>BD_MAIN_HOST,'dbname'=> BD_MAIN_NAME,'user'=>BD_MAIN_LOGIN,'password'=>BD_MAIN_PASSWORD]);

if (!isset($_POST['token'])){$post_token="";} else {$post_token=$_POST['token'];}
if (!isset($_SESSION['token'])){$_SESSION['token']="";}
if (!isset($_POST['quit'])){$post_quit=false;} else {$post_quit=$_POST['quit'];}
if (!isset($_POST['style'])){$post_style="";} else {$post_style=$_POST['style'];}
if (!isset($_POST['action'])){ $post_action="";} else {$post_action=$_POST['action'];}

if (!isset($_COOKIE ['style'])){ $cookieinit="0"; setcookie("style", $cookieinit);} else {$cookieinit=(int)$_COOKIE['style'];}
if (!empty($post_style)){$cookieinit=(int)$post_style;  setcookie("style",$cookieinit);}

switch ($cookieinit){
        case 1:
            $style= 'black';
            break;
        case 2:
            $style='red';
            break;
        default:
            $style="default";
            break;
            }

if (isset($_SESSION["id"])){
$action= empty($_GET["action"]) ? "home" : $_GET["action"];
}else{
    $action="login";
}

check_exit_button($post_quit);
$tokenscheck=tokencheck($post_token);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
switch ($action) {

    case 'login':
        if (!isset($_POST['login'])){$post_login="";} else {$post_login=$_POST['login'];}
        if (!isset($_POST['password'])){$post_password="";} else {$post_password=$_POST['password'];}


        $erorlogin=" ";

        if (($tokenscheck==true)&&(formcheck($post_action)==false)&&(formcheck($post_login)==false)&&
            (formcheck($post_password)==false)&&(formcheck($post_action)==false)&&($post_action=="Registration")){

            $logincheck=BD_message($pdo,['mess'=>'SELECT login FROM users where login=:logins','pleys_1'=> ":logins",
                'pleys_1_value'=>$post_login ],"one");

        if (isset($logincheck["login"])){  $erorlogin="Такой логин уже используется"; }
            else{

                $idmessage=BD_message($pdo,['mess'=>'INSERT INTO users SET login=:lo, password=:pa','pleys_1'=> ":lo",
                    'pleys_1_value'=>$post_login,'pleys_2'=>':pa', 'pleys_2_value'=>password_hash($post_password, PASSWORD_DEFAULT) ],"none");
        }
        }

        if (($tokenscheck==true)&&(formcheck($post_login)==false)&&(formcheck($post_password)==false) && ($post_action=="Login"))
        {
            $post_login = htmlentities($post_login);
            $post_password = htmlentities($post_password);

            $userid=BD_message($pdo,['mess'=>'SELECT id, password FROM users WHERE login=:login','pleys_1'=> ":login",
                'pleys_1_value'=>$post_login ],"all");

            if (!isset($userid["0"]["id"])){
                $erorlogin="Неправильный логин или пароль.";
            } elseif (password_verify($post_password,$userid["0"]["password"])){
                    $_SESSION["id"]=$userid["0"]["id"];
                    header('Location:' . sprintf('%s?action=home', HomeUrl));
                }
            else {
                $erorlogin="Неправильный логин или пароль.";
            }
            }

        echo templates('templates/autoriz.php', [
            'style' => $style,
            'token' => newtoken(),
            'homeurl'=>HomeUrl,
            'error'=> $erorlogin,
        ]);
        break;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'search':

        $searching=[];
        $_POST["Searchtags"]=htmlentities($_POST["Searchtags"]);// имя тега
        if (($tokenscheck==true)&&(formcheck($_POST["Searchtags"])==false)){

            $searching=BD_message($pdo,['mess'=>'SELECT mesage.mes, mesage.date, mesage.userid, tags.tag FROM mesage inner join tagmessageid
            on tagmessageid.messageid=mesage.id inner join tags on tagmessageid.tagid=tags.id WHERE mesage.userid=:users and tags.tag=:tags',
                'pleys_1'=> ":users",'pleys_1_value'=>$_SESSION["id"],'pleys_2'=>':tags', 'pleys_2_value'=>$_POST["Searchtags"] ],"all");
         }
        echo templates('templates/searchtag.php', [
            'style' => $style,
            'token' => newtoken(),
            'homeurl'=>HomeUrl,
            'ishim'=>$_POST["Searchtags"],
            'searching'=>$searching,
        ]);

        break;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'profile':

        echo templates('templates/profile.php', [
            'style' => $style,
            'token' => newtoken(),
            'homeurl'=>HomeUrl,
        ]);

        break;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    default:

        if (!isset($_POST['mesagewindow'])){$post_mesagewindow="";} else {$post_mesagewindow=$_POST['mesagewindow'];}
        if (!isset($_POST['delete'])){ $post_delete="";} else {$post_delete=$_POST['delete'];}
        if (!isset($_POST['countmessage'])){ $post_countmessage="2";} else {$post_countmessage=$_POST['countmessage'];}
        if (!isset($_POST['page'])){ $post_page="1";} else {$post_page=$_POST['page'];}
        if (!isset($_POST['mesageEdit'])){$post_mesageEdit="";} else {$post_mesageEdit=$_POST['mesageEdit'];}
        if (!isset($mesedit)){$mesedit="";}

        if (($tokenscheck==true)&&(formcheck($post_delete)==false)&&($post_action=="Edit")){
            $mesedit=$post_delete;
            $_SESSION['editmessage']=$mesedit;
            }

        if (($tokenscheck==true)&&(formcheck($post_delete)==false)&&($post_action=="Delete")){

            BD_message($pdo,['mess'=>'DELETE FROM mesage WHERE id=:ids','pleys_1'=> ":ids",
                'pleys_1_value'=>$post_delete],"none");
        }

        if (($tokenscheck==true)&&(formcheck($post_mesagewindow)==false))
        {
            $post_mesagewindow = htmlentities($post_mesagewindow);

            BD_message($pdo,['mess'=>'INSERT into mesage set date=now(), mes=:mess,userid=:uses','pleys_1'=> ":mess",
                'pleys_1_value'=>$_POST["mesagewindow"],'pleys_2'=>':uses', 'pleys_2_value'=>$_SESSION["id"] ],"none");

            if (!isset($_POST['tagswindow'])){$_POST['tagswindow']="";}
            if (formcheck($_POST['tagswindow'])==false){
                $resultsting=htmlentities($_POST['tagswindow']);
                $resultsting=trim($resultsting," ");
                $resultsting=trim($resultsting,".");
                $resultsting=trim($resultsting,"\r");
                $resultsting=trim($resultsting,"\n");
                $resultsting=trim($resultsting,"\r");
                $resultsting=trim($resultsting," ");
                $resultarray=explode(", ", $resultsting);

                for ($k=0; $k<count($resultarray);$k++){

                    $tagcheck= BD_message($pdo,['mess'=>'SELECT tag FROM tags WHERE tag=:tagi','pleys_1'=> ":tagi",
                        'pleys_1_value'=>$resultarray[$k]],"all");

                if (!isset($tagcheck["0"])){

                    BD_message($pdo,['mess'=>'INSERT INTO tags SET tag=:tagi','pleys_1'=> ":tagi",
                        'pleys_1_value'=>$resultarray[$k]],"none");
                  }
                }

                $idmessage=BD_message($pdo,['mess'=>'SELECT id FROM mesage where mes=:message And userid=:uses','pleys_1'=> ":message",
                    'pleys_1_value'=>$_POST["mesagewindow"],'pleys_2'=>':uses', 'pleys_2_value'=>$_SESSION["id"] ],"all");

                for ($i=0; $i<count($resultarray);$i++){

                    $idtagi=BD_message($pdo,['mess'=>'SELECT id FROM tags where tag=:tagi','pleys_1'=> ":tagi",
                        'pleys_1_value'=>$resultarray[$i]],"all");

                 BD_message($pdo,['mess'=>'INSERT INTO tagmessageid SET tagid=:tag, messageid=:mesageid','pleys_1'=> ":tag",
                        'pleys_1_value'=>$idtagi[0]["id"],'pleys_2'=>':mesageid', 'pleys_2_value'=>$idmessage[0]["id"]],"none");

                }
            }
        }

        if (($tokenscheck==true)&&(formcheck($post_mesageEdit)==false)&&($_POST["action"])=="Save")
        {
            $post_mesageEdit = htmlentities($post_mesageEdit);

            BD_message($pdo,['mess'=>'UPDATE mesage SET mes=:mess Where id=:userid','pleys_1'=> ":mess",
                'pleys_1_value'=>$post_mesageEdit,'pleys_2'=>':userid', 'pleys_2_value'=>$_SESSION['editmessage'] ],"none");
        }

        if ((!isset($_SESSION['allmessage']))or (!empty($post_delete)) or (!empty($post_mesagewindow))){

            $mesages = BD_message($pdo,['mess'=>'SELECT mesage.id FROM mesage where mesage.userid=:ids','pleys_1'=> ":ids",
                'pleys_1_value'=>$_SESSION["id"]],"all");

            $_SESSION['allmessage']=count($mesages);
        }

        if ((! isset($_SESSION["countmessage"]))or($post_countmessage!=2)){
        $_SESSION["countmessage"]=$post_countmessage; //нужное колчество собщений на странице
        }

        $countstraniz= ceil($_SESSION['allmessage']/$_SESSION["countmessage"]);
        $starts= (int)$_SESSION["countmessage"]*$post_page-$_SESSION["countmessage"];
        $kols=(int)$_SESSION["countmessage"];

        $selec=$pdo->prepare("SELECT mesage.mes, mesage.userid, mesage.date, mesage.id FROM mesage where mesage.userid=:ids order by mesage.date DESC Limit $starts,$kols");
        $selec->execute([
            'ids'=>$_SESSION["id"],
        ]);
        $mesages = $selec->fetchAll(PDO::FETCH_ASSOC);

        echo templates('templates/home.php', [
             'token' => newtoken(),
             'style' => $style,
             'mesage'=>$mesages,
            'homeurl'=>HomeUrl,
            'messEdit'=>$mesedit,
            'kolstraniz'=>$countstraniz,
        ]);
        break;
}
