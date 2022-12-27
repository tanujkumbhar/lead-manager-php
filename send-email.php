<?php

require_once './app/Email.php';

$email = new Email();

// ------- DADOS

$usuario = '';
$senha = '';
$destinarios = [];
$titulo = 'EMAIL DE TESTE';
$conteudo = file_get_contents('./content.html');
$conteudoAlternativo = 'Não foi possível carregar o documento HTML.';
$esconderDestinarios = false;
$anexos = null;
$sucesso = function () {
    echo "Email enviado com sucesso.";
};
$falha = function ($err) {
    echo "Não foi possível concluir esta ação: " . $err;
};

// -------

$email->login($usuario, $senha);
$email->send(
    $destinarios,
    $titulo,
    $conteudo,
    $conteudoAlternativo,
    $esconderDestinarios,
    $anexos,
    $sucesso,
    $falha
);
