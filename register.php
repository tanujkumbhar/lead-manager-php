<?php

// *********************

// CONFIGURAÇÕES PRINCIPAIS
$register = [
    "name"  => $_POST['newName'],
    "email" => $_POST['newEmail'],
];
$csvHeader  = ['ID', 'Nome', 'Email'];
$csvSep     = ',';

// CONFIGURAÇÕES SECUNDÁRIAS
$csvPath    = './emails/emails.csv';
$jsonPath   = './emails/emails.json';
$json       = @file_get_contents($jsonPath);
$jsonData   = $json ? $json : "[]";

$arrayData  = json_decode($jsonData);

// FUNÇÕES APÓS TÉRMINO
if (addRegister($register)) {
    echo "<b> {$_POST['newName']} </b> cadastrado com sucesso no email <b> {$_POST['newEmail']} </b>";
    echo "<br><a href='./index.php'>Voltar</a>";
} else {
    echo "Não foi possível cadastrar <b>{$_POST['newName']}</b>.";
}

// *********************

function addRegister($data) {
    global $arrayData;
    global $jsonPath;

    $newLine        = new stdClass;
    $newLine->id    = count($arrayData) + 1;

    foreach($data as $key => $value) {
        $newLine->$key = $value;
    }

    if (!array_push($arrayData, $newLine)) {
        return false;
    }

    if (!file_put_contents($jsonPath, toJson($arrayData))) {
        return false;
    }

    global $csvPath;
    global $csvHeader;
    global $csvSep;

    $csv = fopen($csvPath, 'w');

    fputcsv($csv, $csvHeader, $csvSep);
    foreach ($arrayData as $register) {
        $row = [];

        foreach ($register as $attribute) {
            array_push($row, $attribute);
        }

        fputcsv($csv, $row, $csvSep);
    }
    fclose($csv);

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

