<?php
/**
 * @param $namefile
 * @param array $peredArgym
 * @return string
 */
function templates($namefile, array $peredArgym=[]){
ob_start();
    extract($peredArgym);
    require($namefile);
    $retur=ob_get_contents();
ob_end_clean();

return $retur;
}

/**
 * @param $stroka1
 * @return bool
 */
function formcheck ($stroka1){
        if (!empty($stroka1)){
        $stroka2=htmlentities($stroka1);
        $stroka2=str_replace("\n","",$stroka2);
        $stroka2=str_replace("\r","",$stroka2);
        $stroka2=trim($stroka2," ");
        $stroka2=str_replace("\n","",$stroka2);
        $stroka2=str_replace("\r","",$stroka2);
        return $stroka2=="" ? true : false;
        }
else { return true;}
}

/**
 * @return string
 */
function newtoken () {
    $tokens=uniqid();
    $_SESSION['token']=$tokens;
    return $tokens;
}

/**
 * @param $poststroka
 */
function exits($poststroka){   // $_POST["quit"]
    if (($poststroka==true)&&($_SESSION['token']==$_POST['token'])&&(formcheck($poststroka)==false)){
        $_SESSION["id"]=null;
        header('Location:' . sprintf('%s?action=login', HomeUrl));
    }
}

/**
 * @return bool
 */
function tokencheck (){
    if (($_SESSION['token'])==($_POST['token'])){
        return true;
    } else {
        return false;
    }
}

/**
 * @param array $config
 * @return PDO
 */
function connect(array $config){
    try{
        return new PDO("mysql: host={$config['host']}; dbname={$config['dbname']}; charset=utf8",$config['user'],$config['password']);
    } catch (Exception $e){
        file_put_contents("log.txt", $e.date("j.n.Y H:i:s"),FILE_APPEND | LOCK_EX);
        echo "<h1>Ошибка 503: Сервис временно не доступен.</h1>";
        exit();
    }
}



