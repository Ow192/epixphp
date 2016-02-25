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