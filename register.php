<?php

$emailsPath = './emails/emails.json';

$json       = @file_get_contents($emailsPath);
$jsonData   = $json ? $json : "[]";
$arrayData  = json_decode($jsonData);

$name   = $_POST['newName'];
$email  = $_POST['newEmail'];

if (addRegister($name, $email)) {
    echo "<b>{$_POST['newName']}</b> cadastrado com sucesso no email <b>{$_POST['newEmail']}</b>";
} else {
    echo "Não foi possível cadastrar.";
}

function addRegister($nome, $email) {
    global $arrayData;
    global $emailsPath;

    $newLine = new stdClass;

    $newLine->id    = count($arrayData) + 1;
    $newLine->name  = $nome;
    $newLine->email = $email;

    if (!array_push($arrayData, $newLine)) {
        return false;
    }

    if (!file_put_contents($emailsPath, toJson($arrayData))) {
        return false;
    }

    return true;
}

function toJson($data) {
    $json = json_encode($data,
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_UNICODE |
                        JSON_UNESCAPED_SLASHES |
                        JSON_HEX_QUOT |
                        JSON_PRESERVE_ZERO_FRACTION);
    return $json;
}