<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="container">
    <div class="row">
        <form class="form-control shadow-sm w-auto mx-auto my-4 p-4" action="./register.php" method="post">
            <h2 class="fs-3 mb-4 text-center">Registrar um novo cadastro</h2>

            <div class="input-group mb-2">
                <span class="input-group-text">Nome</span>
                <input name="newName" type="text" class="form-control" placeholder="Rogério" aria-label="Name" required>
            </div>

            <div class="input-group mb-4">
                <span class="input-group-text">Email</span>
                <input name="newEmail" type="email" class="form-control" placeholder="regerio2023@gmail.com" aria-label="Email" required>
            </div>

            <input class="btn btn-primary w-100" type="submit" value="Enviar">
        </form>
    </div>
    <hr>
    <div class="row">
        <div class="p-4 my-4 w-auto mx-auto form-control shadow-sm">
            <h2 class="fs-3 mb-4 text-center w-100">Baixar cadastros</h2>
            <a href="./generate-csv.php" class="btn btn-outline-success w-100 mb-2">CSV</a>
            <a href="./emails/emails.json" class="btn btn-outline-success w-100" download="">JSON</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <form class="form-control" action="./send-email.php" method="post">
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
            <input type="text" placeholder="Nome Sobrenome" name="replyName" id="test">
            <input type="submit" value="Enviar email">
        </form>
    </div>
</body>

</html>