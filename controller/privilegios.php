<?php
require_once("../models/users.php");
session_start();
if (isset($_SESSION["user"])){
    $user = unserialize($_SESSION["user"]);
    if ($user->getGrupo() != "axuliar_gerente" || $user->getGrupo() != "gerente"){
        header("");
    }
}