<?php

function truncate($text, $length) {
   return '<p>' . wp_trim_words($text,$length,"...") . '</p>';
}


?>
