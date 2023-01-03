<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.7.0/build/highlight.min.js" rel="stylesheet" crossorigin="anonymous" defer>
</head>
<body class="container">

    <form action="./register.php" method="post">
        <h2>Registrar novo cadastro</h2>
        <p>Nome</p>
        <input type="text" name="newName" id=""><br>
        <p>Email</p>
        <input type="email" name="newEmail" id="">
        <input type="submit" value="Registrar">
    </form>

    <hr>

    <form action="./send-email.php" method="post">
        <h2>Enviar email</h2>
        <p>Destinários</p>
        <?php

$jsonData = file_get_contents('./emails/emails.json');
$cadastros = json_decode($jsonData);

foreach ($cadastros as $cadastro) {
    echo $cadastro->email;
    echo "<br>";
};

        ?>

        <p>Título</p>
        <input type="text" name="title" id=""><br>
        <p>Corpo</p>
        <textarea name="body" id="" cols="30" rows="10">

        </textarea>
        <p>Conteúdo alternativo</p>
        <textarea name="altBody" id="" cols="30" rows="10">

        </textarea>
        <p>Esconder destinários</p>
        <label for="hideAddress">Sim</label>
        <input type="radio" name="hideAdds" value="true" checked id="hideAddress">
        <label for="dontHideAddress">Não</label>
        <input type="radio" name="hideAdds" value="false" id="dontHideAddress">

        <p>Anexos</p>
        <input type="file" name="attachments" id="">

        <p>Mostrar como autor</p>
        <input type="email" placeholder="email@example.com" name="fromEmail" id="">
        <input type="text" placeholder="Nome Sobrenome" name="fromName" id="">

        <p>Responder email à</p>
        <input type="email" placeholder="email@example.com" name="replyEmail" id="">
        <input type="text" placeholder="Nome Sobrenome" name="replyName" id="">
        <input type="submit" value="Enviar email">
    </form>

    <div class="p-3 mx-auto col-3 border border-secondary rounded my-4">
        <p class="text-center text-dark">Baixar cadastros</p>
        <a href="./generate-csv.php" class="text-center btn btn-primary">CSV</a>
        <a href="./emails/emails.json" class="text-center btn btn-primary" download="">JSON</a>
    </div>
</body>
</html>