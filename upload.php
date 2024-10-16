<?php
require 'functions.php'; // Подключаем файл с функциями

$errors = [];
$uploadedFiles = getUploadedFiles(); // Получаем загруженные изображения

// Обработка загрузки файла
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_FILES['photo'])) {
        $errors[] = 'Нет данных для загрузки файла';
    } else {
        list($success, $result) = uploadImage($_FILES['photo']);
        if ($success) {
            header("Location: index.php"); // Перенаправляем на главную страницу
            exit();
        } else {
            $errors = array_merge($errors, $result);
        }
    }
}