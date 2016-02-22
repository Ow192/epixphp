<?php
/*
 * namefile- templates/autoriz.php
 * peredArgym
 * return - html and date
 */
function templates($namefile, array $peredArgym=[]){
ob_start();
    extract($peredArgym);
    require($namefile);
    $ret=ob_get_contents();
ob_end_clean();

return $ret;
}
/*
 * str - string or array["..."]
 * return - pusto? (net simvolov... ) true/false ,
 */
function formcheck ($str1){
        if (!empty($str1)){
        $str2=htmlentities($str1);
        $str2=str_replace("\n","",$str2);
        $str2=trim($str2," ");
        $str2=str_replace("\n","",$str2);
        return $str2=="" ? true : false;
        }
    else { return true;}
}
/*
 * str - string or array["..."]
 * return - pusto? (net simvolov... ) true/false ,
 */
function newtoken () {
    $_SESSION['tokens']=uniqid();
}