<?php
$dataFile = 'posts.json';

header('Content-Type: application/json');

if (!file_exists($dataFile)) {
    echo '[]';
    exit;
}

$posts = json_decode(file_get_contents($dataFile), true);
echo json_encode(array_reverse($posts));
?>
