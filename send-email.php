<?php

require_once './app/Email.php';
$cadastros = json_decode(file_get_contents('./emails/emails.json'));

$email = new Email();

echo '<pre>';
print_r($_POST);
print_r($_FILES);
echo '</pre>';

// *********************
// DADOS

$usuario = '';
// login da conta no Gmail
$senha = '';
// senha da conta no Gmail
$destinarios = [];
foreach ($cadastros as $cadastro) {
    array_push($destinarios, $cadastro->email);
};
// endereços que irão receber o email
$titulo = @$_POST['title'];
// título  do email (aparece na caixa de entrada)
$conteudo = @$_POST['body'];
// body do email (conteúdo)
$conteudoAlternativo = @$_POST['altBody'];
// conteúdo exibido para clientes de email sem suporte ao HTML (raro)
$esconderDestinarios = @$_POST['showAddresses'] ? true : false; 
// mostrar quem são todos os destinários do email nas informações do email
$anexos = @$_FILES['attachments'];
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

$autor = $_POST['fromEmail'];
// endereço que será exibido como autor do email
$nomeAutor = $_POST['fromName'];
// nome que será exibido como autor do email
$responda = $_POST['replyEmail'];
// destinário da resposta (endereço que estará na opção 'responder' do email)
$nomeResponda = $_POST['replyName'];
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
