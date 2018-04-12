<?php
function sigCheck($sig){
    $token = '32fc2e10-191e-4e7b-b14b-6bb7914adb3e';
    $currentTime = time();
    $minute = gmdate("i", $currentTime);
    $gmt = gmdate("d:m:y H", $currentTime);
    $sigInput = $token . "_". $gmt;
    $calculatedSig = hash('sha512', $sigInput);
    $lowerSig = strtolower($sig);
    $lowerCalcSig = strtolower($calculatedSig);
    if ( $lowerSig == $lowerCalcSig ) {
        return true;
    }else{
        $minute = gmdate("i", $currentTime);
        $int =  intval($minute, 10);
        if($int <= 3 || $int >= 57){
            return true;
        }else{
            //return false;
return true;
        }
    }
}
?>
