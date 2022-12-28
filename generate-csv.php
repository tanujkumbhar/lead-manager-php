<?php

$filePath = './emails/emails.csv';
$separator = ',';
$sheetHeader = ['ID', 'Nome', 'Email'];
$data = json_decode(file_get_contents('./emails/emails.json'));

$csv = fopen($filePath, 'w');
fputcsv($csv, $sheetHeader, $separator);

foreach ($data as $value) {
    $row = [
        $value->id,
        $value->name,
        $value->email
    ];
    fputcsv($csv, $row, $separator);
}

fclose($csv);

header('Content-Disposition: attachment; filename="' . basename($filePath) . '";');
readfile($filePath);

exit;