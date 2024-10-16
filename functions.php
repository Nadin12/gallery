<?php
const UPLOAD_ERROR_MESSAGES = [
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
];

const PHOTO_MAX_SIZE = 2 * 1024 * 1024; // 2Mb
const PHOTO_AVAILABLE_TYPES = ['image/jpeg', 'image/png'];
const PHOTO_DIR = 'images';

// Функция для загрузки изображения
function uploadImage($file) {
    $errors = [];

    // Проверка на ошибки загрузки
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = UPLOAD_ERROR_MESSAGES[$file['error']];
    } else {
        // Проверка типа файла
        if (!in_array($file['type'], PHOTO_AVAILABLE_TYPES)) {
            $errors[] = 'Файл не является изображением. Пожалуйста, загрузите JPG или PNG.';
        }
        // Проверка размера файла
        if ($file['size'] > PHOTO_MAX_SIZE) {
            $errors[] = 'Фото слишком большое. Максимальный размер 2 Мб.';
        }
        // Если ошибок нет, продолжаем загрузку
        if (count($errors) == 0) {
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $uniqueName = uniqid() . '.' . $extension;
            $fileName = PHOTO_DIR . DIRECTORY_SEPARATOR . $uniqueName;
            if (!move_uploaded_file($file['tmp_name'], $fileName)) {
                $errors[] = 'Фото не удалось загрузить';
            } else {
                return [true, $uniqueName]; // Успешная загрузка
            }
        }
    }
    return [false, $errors]; // Неудача
}

// Функция для получения списка загруженных изображений
function getUploadedFiles(): array {
    if (is_dir(PHOTO_DIR)) {
        return array_values(array_filter(scandir(PHOTO_DIR), fn($file) => preg_match('/\.(jpg|jpeg|png)$/i', $file)));
    }
    return [];
}
