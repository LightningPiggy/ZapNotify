<?php

function readlastline($fileName)
{
       $fp = @fopen($fileName, "r");
       $begining = fseek($fp, 0);
       $pos = -2;
       $t = " ";
       while ($t != "\n") {
             fseek($fp, $pos, SEEK_END);
             if(ftell($fp) == $begining){
              break;
             }
             $t = fgetc($fp);
             $pos = $pos - 1;
       }
       $t = fgets($fp);
       fclose($fp);
       return $t;
}

echo readlastline('payment_metrics.csv');
