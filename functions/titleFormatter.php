<?php
function titleFormatter( $title ) {
    $words = explode( ' ', $title );
    $wordsLength = count($words);
    $_title = '';
    if( $wordsLength == 3) {
        $_title .='<span>' .$words[0].' '.$words[1].'</span>';
        $_title .='<span>' .$words[2].'</span>';
    } elseif ($wordsLength == 2) {
        $_title .='<span>' .$words[0].'</span>';
        $_title .='<span>' .$words[1].'</span>';
    } elseif ($wordsLength == 1) {
        $_title .='<span></span><span>' .$words[0].'</span>';
    } else {
        $_title .='<span>' .$title. '</span>';
    }
    return $_title;
}
