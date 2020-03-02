<?php
function randomString($lenght){
    $chars = "0123456789012345678901234567890123456789";
    srand ((double)microtime()* 1000000);
    $str ="";
    $i =1;
        while($i <= $lenght){
            $num = rand() %33;
            $tmp = substr($chars, $num, 1);
            $str = $str . $tmp;
            $i++;
    }
return $str;
}
echo randomString(rand(5 ,5));