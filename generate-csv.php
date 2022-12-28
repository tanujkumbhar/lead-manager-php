<?php

$caminho = './emails/emails.csv';
$delimitador = ',';
$dados = [
    [
        'ID',
        'Nome',
        'Email'
    ],
    [
        1,
        'Maria',
        'maria@example.com'
    ],
    [
        2,
        'João',
        'joao@example.com'
    ],
    [
        3,
        'Joana',
        '2023.joana@example.com'
    ],
    [
        4,
        'Maria',
        'maria@example.com'
    ],
    [
        5,
        'João',
        'joao@example.com'
    ],
    [
        6,
        'Joana',
        '2023.joana@example.com'
    ],
];

$csv = fopen($caminho, 'w');

foreach ($dados as $linha) {
    fputcsv($csv, $linha, $delimitador);
}

fclose($csv);

header('Content-Disposition: attachment; filename="' . basename($caminho) . '";');
readfile($caminho);

exit;