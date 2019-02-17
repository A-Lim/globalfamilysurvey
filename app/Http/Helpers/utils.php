<?php

use App\ErrorLog;

function log_error($action, $error) {
    ErrorLog::create([
        'action' => $action,
        'error' => $error,
    ]);
}

function splitWords($text, $noOfWords) {
    $words = str_word_count($text, 1);
    $pieces = [];
    foreach(array_chunk($words, $noOfWords) as $array){
        $pieces[] = implode(' ', $array);
    }
    return $pieces;
}
