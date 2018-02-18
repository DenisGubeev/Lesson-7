<?php
    $allFiles = glob('tests/*.json');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List</title>
</head>
<body>
    <a href="admin.php" class="back"><div>Назад</div></a>
    <hr>
    <?php if (!empty($allFiles)): ?>
        <?php foreach ($allFiles as $file): ?>
            <div>
                <h1><?php echo str_replace('tests/', '', $file); ?></h1><br>
                <em>Загружен: <?php echo date("d-m-Y", filemtime($file)) ?></em><br>
                <a href="test.php?number=<?php echo array_search($file, $allFiles); ?>"Перейти на страницу с тестом ></a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (empty($allFiles)) echo 'Пока не загружено ни одного теста';?>
</body>
</html>
