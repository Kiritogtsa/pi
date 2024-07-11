<?php
// valida o campos, a tecnica usada foi uma bem simples eu so crio um array com base da string recebida, e se o array for maior que um entao e invalido
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