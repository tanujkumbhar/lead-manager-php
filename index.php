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
        <div class="my-4 w-auto mx-auto card shadow-sm p-0" style="min-width: min(280px, 90vw);">
            <h2 class="fs-3 text-center card-header">Cadastros</h2>
            <ul class="list-group list-group-flush">
                <?php

                $jsonData = file_get_contents('./emails/emails.json');
                $cadastros = json_decode($jsonData);

                foreach ($cadastros as $cadastro) {
                    echo "<li class='list-group-item'>$cadastro->email</li>";
                };

                ?>
            </ul>
            <a href="./generate-csv.php" class="btn btn-outline-success mx-3 mt-4">Baixar CSV</a>
            <a href="./emails/emails.json" class="btn btn-outline-success mx-3 mt-2 mb-4" download="">Baixar JSON</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <form class="form-control p-3 my-4" action="./send-email.php" method="post">
            <h2 class="fs-2 p-3">Enviar email</h2>

            <div class="mb-4">
                <label for="title" class="form-label">Destinários</label>
                <ul class="list-group">
                    <?php

                    $jsonData = file_get_contents('./emails/emails.json');
                    $cadastros = json_decode($jsonData);

                    foreach ($cadastros as $cadastro) {
                        echo "<li class='list-group-item'>$cadastro->email</li>";
                    };

                    ?>
                </ul>
                <div class="form-text">Todos os endereços que receberam o email</div>
            </div>

            <div class="mb-4">
                <label for="title" class="form-label">Título do email</label>
                <input name="title" id="title" type="text" class="form-control">
                <div class="form-text">O título que será exibido no topo do email e na caixa de entrada do receptor</div>
            </div>

            <div class="mb-4">
                <label for="body" class="form-label">Corpo do email</label>
                <code>
                    <textarea class="w-100 form-control" name="body" id="body"></textarea>
                </code>
                <div class="form-text">O conteúdo que estará de fato no email (em HTML)</div>
            </div>

            <div class="mb-4">
                <label for="altBody" class="form-label">Conteúdo alternativo</label>
                <textarea class="w-100 form-control" name="altBody" id="altBody"></textarea>
                <div class="form-text">Um texto para os clientes de email que não suportam HTML</div>
            </div>


            <div class="mb-4 form-check">
                <input class="form-check-input" type="checkbox" value="hideAdds" id="hideAdds">
                <label class="form-check-label" for="hideAdds">
                    Esconder destinários
                    <span class="form-text">(Se será possível que cada cliente veja todos que também receberam o email)</span>
                </label>
            </div>

            <div class="mb-3">
                <label for="attachments" class="form-label">Anexos</label>
                <input class="form-control" type="file" name="attachments" id="attachments">
                <div class="form-text">Arquivos que serão enviados junto ao emailL</div>
            </div>

            <p>Mostrar como autor</p>
            <input type="email" placeholder="email@example.com" name="fromEmail" id="">
            <input type="text" placeholder="Nome Sobrenome" name="fromName" id="">

            <div class="input-group">
                <span class="input-group-text">Mostrar como autor</span>
                <input type="text" class="form-control" placeholder="Maria Clara">
                <input type="email" class="form-control" placeholder="contato.mariaclara@example.com">
            </div>

            <p>Responder email à</p>
            <input type="email" placeholder="email@example.com" name="replyEmail" id="">
            <input type="text" placeholder="Nome Sobrenome" name="replyName" id="test">
            <input type="submit" value="Enviar email">
        </form>
    </div>
</body>

</html>