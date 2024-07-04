<?php

function validarinput($data){
    $datas = explode(";", $data);
    if (count($datas) > 1){
        return false;
    }
    $datas = explode("(", $data);
    if (count($datas) > 1){
        return false;
    }
    $datas = explode(")", $data);
    if (count($datas) > 1){
        return false;
    }
    $datas = explode("=",$data);
    if (count($datas) > 1){
        return false;
    }
    return true;
}