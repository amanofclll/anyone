<?php
$uploadDir = 'uploads/';
$dataFile = 'posts.json';

// Create directories if they don't exist
if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
if (!file_exists($dataFile)) file_put_contents($dataFile, '[]');

// Handle file upload
$fileName = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '.' . $extension;
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName);
}

// Create post data
$post = [
    'title' => $_POST['title'] ?? '',
    'text' => $_POST['text'] ?? '',
    'link' => $_POST['link'] ?? '',
    'image' => $fileName,
    'timestamp' => time()
];

// Get existing posts and add new one
$posts = json_decode(file_get_contents($dataFile), true);
$posts[] = $post;

// Keep only last 10 posts
if (count($posts) > 10) {
    $posts = array_slice($posts, -10);
}

// Save data
file_put_contents($dataFile, json_encode($posts));

header('Content-Type: application/json');
echo json_encode(['status' => 'success']);
?>
