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
            <h2 class="fs-3 mb-4 text-center">Register a new account</h2>

            <div class="input-group mb-2">
                <span class="input-group-text">Name</span>
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
            <h2 class="fs-3 text-center card-header">Registrations</h2>
            <ul class="list-group list-group-flush">
                <?php

                $jsonData   = @file_get_contents('./emails/emails.json');
                $cadastros  = json_decode($jsonData);

                if ($cadastros)
                    foreach ($cadastros as $cadastro) {
                        echo "<li class='list-group-item'>$cadastro->email</li>";
                    };

                ?>
            </ul>
            <a href="./emails/emails.csv" class="btn btn-outline-success mx-3 mt-4" download="">Download CSV</a>
            <a href="./emails/emails.json" class="btn btn-outline-success mx-3 mt-2 mb-4" download="">Download JSON</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <form class="form-control w-auto mx-auto my-4 p-4 card shadow-sm" action="./send-email.php" method="post" enctype="multipart/form-data" target="_blank">
            <h2 class="fs-2 mb-5">Send email</h2>

            <div class="mb-5">
                <label for="title" class="form-label fs-4">Recipients</label>
                <ul class="list-group" title="Coletando emails no arquivo emails.json">
                    <?php
    
                    $jsonData   = @file_get_contents('./emails/emails.json');
                    $cadastros  = json_decode($jsonData);
    
                    if ($cadastros)
                        foreach ($cadastros as $cadastro) {
                            echo "<li class='list-group-item'>$cadastro->email</li>";
                        };
    
                    ?>
                </ul>
                <div class="form-text">Todos os endereços que receberam o email</div>
            </div>

            <div class="mb-5">
                <label for="title" class="form-label fs-4">Título do email</label>
                <input name="title" id="title" type="text" class="form-control" placeholder="Confira agora a sua retrospectiva de 2022">
                <div class="form-text">O título que será exibido no topo do email e na caixa de entrada do receptor</div>
            </div>

            <div class="mb-5">
                <label for="body" class="form-label fs-4">Corpo do email</label>
                <code>
                    <textarea class="w-100 form-control" name="body" id="body" placeholder="<h1>Essa é a sua retrospectiva de 2022</h1>
<p>Essas foram as coisas que você fez em 2022</p>"></textarea>
                </code>
                <div class="form-text">O conteúdo que estará de fato no email (em HTML)</div>
            </div>

            <div class="mb-5">
                <label for="altBody" class="form-label fs-4">Conteúdo alternativo</label>
                <textarea class="w-100 form-control" name="altBody" id="altBody">O seu cliente de email não suporta o documento.</textarea>
                <div class="form-text">Um texto para os clientes de email que não suportam HTML</div>
            </div>


            <div class="mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="hideAddresses" id="hideAddresses" checked>
                    <label class="form-check-label" for="hideAddresses">
                        Esconder destinatários
                    </label>
                </div>
                <div class="form-text">Não permitir que todos os outros destinatários sejam revelados a cada receptor</div>
            </div>

            <div class="mb-5">
                <label for="attachments" class="form-label fs-4">Anexos</label>
                <input class="form-control" type="file" name="attachments[]" id="attachments" multiple>
                <div class="form-text">Arquivos que serão enviados junto ao email</div>
            </div>

            <div class="mb-5">
                <label for="fromName" class="form-label fs-4">Mostrar</label>
                <div class="input-group">
                    <span class="input-group-text">Autor</span>
                    <input type="text" class="form-control" name="fromName" id="fromName" placeholder="Maria Clara">
                    <input type="email" class="form-control" name="fromEmail" id="fromEmail" placeholder="contato.mariaclara@example.com">
                </div>
                <div class="form-text mb-3">Nome e email que aparecerá como autor do email</div>

                <div class="input-group">
                    <span class="input-group-text">Responder</span>
                    <input type="text" class="form-control" name="replyName" id="replyName" placeholder="Maria Clara">
                    <input type="email" class="form-control" name="replyEmail" id="replyEmail" placeholder="contato.mariaclara@example.com">
                </div>
                <div class="form-text">Nome e email que aparecerá quando o receptor selecionar opção "Responder Email"</div>
            </div>
            
            <div class="col-3 offset-9 mt-4 pt-2">
                <button type="submit" class="btn btn-primary w-100">Enviar Email</button>
            </div>

        </form>
    </div>
</body>

</html>