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
function check_exit_button($poststroka){   // $_POST["quit"]
    if (($poststroka==true)&&($_SESSION['token']==$_POST['token'])&&(formcheck($poststroka)==false)){
        $_SESSION["id"]=null;
        header('Location:' . sprintf('%s?action=login', HomeUrl));
    }
}

/**
 * @return bool
 */
function tokencheck ($post_tokens){
    if (($_SESSION['token'])==$post_tokens){
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

function __autoload($classname){
    include '../classes/'.$classname.'.php';
}


function BD_message ($connectBD,array $message,$results){

    $selec=$connectBD->prepare($message['mess']);
    $pleyscount=(count($message)-1)/2;
    if ($pleyscount==2){
        $selec->execute([
        $message['pleys_1']=> $message['pleys_1_value'],
        $message['pleys_2']=> $message['pleys_2_value'],
    ]);}
    if ($pleyscount==1){
        $selec->execute([
            $message['pleys_1']=> $message['pleys_1_value'],
        ]);}
    switch($results){
        case 'one':
            return $selec->fetch(PDO::FETCH_ASSOC);
            break;
        case 'all':
            return $selec->fetchAll(PDO::FETCH_ASSOC);
            break;
        case 'none':
            return null;
            break;
        default:
            return $selec->fetchAll(PDO::FETCH_ASSOC);
            break;
    }
}


//all fetch none
// 1 /2