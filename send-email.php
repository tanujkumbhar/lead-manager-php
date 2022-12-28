<?php

require_once './app/Email.php';

$email = new Email();

// *********************
// DADOS

$usuario = '';
// login da conta no Gmail
$senha = '';
// senha da conta no Gmail
$destinarios = ['', ''];
// endereços que irão receber o email
$titulo = 'EMAIL DE TESTE 2';
// título  do email (aparece na caixa de entrada)
$conteudo = '<h1>Título</h1><p>Conteúdo</p>';
// body do email (conteúdo)
$conteudoAlternativo = 'Não foi possível carregar o documento HTML.';
// conteúdo exibido para clientes de email sem suporte ao HTML (raro)
$esconderDestinarios = false; 
// mostrar quem são todos os destinários do email nas informações do email
$anexos = null;
// arquivos/documentos a serem anexados ao email
$sucesso = function ($adds) {
    echo "Email enviado com sucesso: <b>" . implode(', ', $adds) . "</b>";
};
// função que será executada quando o email for enviado com sucesso
$falha = function ($err) {
    echo "Não foi possível concluir esta ação: <b>" . $err . "</b>";
};
// função que será executada em caso de falhas no envio do email

// EXTRA (opcionais)

$autor = 'avisos@val.com';
// endereço que será exibido como autor do email
$nomeAutor = 'Victor - Val';
// nome que será exibido como autor do email
$responda = 'suporte@val.com';
// destinário da resposta (endereço que estará na opção 'responder' do email)
$nomeResponda = 'Suporte - Val';
// nome do destinário da resposta do email ^
// *********************

$email->login($usuario, $senha);
$email->setFrom($autor, $nomeAutor);
$email->setReply($responda, $nomeResponda);
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



// É possível enviar email individuais e com o conteúdo dinâmico criando um laço
// no array dos destinários e executando o método de envio para cada endereço ->

// foreach ($destinarios as $add) {
//     $titulo = "Aviso para $add";
//     $conteudo = "Olá, $add, gostaria de avisar que este é um email automático.";

//     $email->send(
//         $add,
//         $titulo,
//         $conteudo,
//         $conteudoAlternativo,
//         $esconderDestinarios,
//         $anexos,
//         $sucesso,
//         $falha
//     );
// }
