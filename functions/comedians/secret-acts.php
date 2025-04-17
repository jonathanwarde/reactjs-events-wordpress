<?php
/**
 * Check if Act is 'secret'
 * @param $c - ie. $comedian
 * @return bool
 */
function isSecretAct($c) {
     $secretActUrls = [
       'top-secret-acts-tba',
       'acts-yet-to-be-confirmed',
       'special-celebrity-guest',
     ];
     foreach ($secretActUrls as $url){
         if($c->post_name != $url){
             return false;
         }
     }
     return true;
}
