<?php

require_once './app/Email.php';

// *********************

// LOGIN
$usuario    = '';
$senha      = '';

// ENDEREÇOS
$destinos   = coletarEmailsJson('./emails/emails.json');

// CONTEÚDO
$titulo     = @$_POST['title'];
$corpo      = @$_POST['body'];
$corpoAlt   = @$_POST['altBody'];
$anexos     = @$_FILES['attachments'];

// CONFIGURAÇÕES
$esconderAlvos  = @$_POST['hideAddresses'] ? true : false; 
$autorEmail     = @$_POST['fromEmail'];
$autorNome      = @$_POST['fromName'];
$respondaEmail  = @$_POST['replyEmail'];
$respondaNome   = @$_POST['replyName'];

// DEPOIS DE ENVIAR
$emSucesso  = function ($adds) {
    echo "Email enviado com sucesso: <b>" . implode(', ', $adds) . "</b>";
    echo "<br><a href='./index.php'>Voltar</a>";
};
$emFalha    = function ($err) {
    echo "Não foi possível concluir esta ação: <b>" . $err . "</b>";
};

// *********************

$email = new Email;

$email->login($usuario, $senha);
$email->setFrom($autorEmail, $autorNome);
$email->setReply($respondaEmail, $respondaNome);
$email->send(
    $destinos,
    $titulo,
    $corpo,
    $corpoAlt,
    $esconderAlvos,
    $anexos,
    $emSucesso,
    $emFalha
);


// Com um laço é possível enviar emails individuais
// Dessa forma é possível criar configurações dinâmicas, para cada destinário
// Neste exemplo, apenas o título e o conteúdo são dinâmicos
// Porém todas as configurações anteriores podem ser feitas dentro do loop

// foreach ($destinos as $add) {
//     $titulo  = "Aviso para $add";
//     $corpo   = "Olá, $add, este é um email individual.";

//     $email->send(
//         $destinos,
//         $titulo,
//         $corpo,
//         $corpoAlt,
//         $esconderAlvos,
//         $anexos,
//         $emSucesso,
//         $emFalha
//     );
// }


function coletarEmailsJson($jsonPath) {
    $emails         = [];
    $cadastrosJson  = @file_get_contents($jsonPath);
    $cadastros      = @json_decode($cadastrosJson);

    if ($cadastros) {
        foreach ($cadastros as $cadastro) {
            array_push($emails, $cadastro->email);
        };
    }

    return $emails;
}