<?php
require 'functions.php'; // Подключаем файл с функциями

$errors = []; // Массив для ошибок
$uploadedFiles = getUploadedFiles(); // Получаем загруженные изображения
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Фотогалерея</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="photoswipe/dist/photoswipe.css">
</head>
<body>

<h1>Фотогалерея</h1>

<!-- Форма загрузки фото -->
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="photo" accept="image/jpeg,image/png" required>
    <button type="submit">Загрузить</button>
</form>

<!-- Сообщения об ошибках -->
<?php if ($errors): ?>
    <div style="color: red;">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Галерея -->
<div class="gallery">
    <?php foreach ($uploadedFiles as $file): ?>
        <a href="<?= PHOTO_DIR . '/' . $file ?>" data-pswp-width="800" data-pswp-height="600">
            <img src="<?= PHOTO_DIR . '/' . $file ?>" alt="<?= $file ?>">
        </a>
    <?php endforeach; ?>
</div>

<!-- PhotoSwipe -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--prev" title="Previous (arrow left)"></button>
                <button class="pswp__button pswp__button--next" title="Next (arrow right)"></button>
            </div>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>

<!-- JS для PhotoSwipe -->
<script src="photoswipe/dist/photoswipe.esm.js" type="module"></script>
<script src="photoswipe/dist/photoswipe-lightbox.esm.js" type="module"></script>
<script src="js/script.js" type="module"></script>
</body>
</html>
