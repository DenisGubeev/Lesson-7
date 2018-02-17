<?php

if (isset($_POST['upload'])) {
    header('Location: list.php');
	exit;
}

if (isset($_POST['upload'])) {
	if (isset($_FILES['myfile'])) {
    $file = $_FILES['myfile'];
	}
	if (!empty(glob('tests/*.json'))) {
        $allFiles = glob('tests/*.json');
		} else {
        $allFiles = [0];
		}
	$uploadfile = 'tests/' . basename($_FILES['myfile']['name']);
		if (!empty($file['name']) && $file['error'] == UPLOAD_ERR_OK && 
		move_uploaded_file($file['tmp_name'],$uploadfile)) {
			echo 'Файл загружен';
	} else {
		echo 'Файл не загружен, попробуйте еще раз.';
	}
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php if (!isset($_POST['create']) && !isset($_POST['upload'])): ?>
    <form  method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Загрузите свой тест в формате json</legend>
            <input type="file" name="myfile" required>
            <input type="submit" value="Добавить в базу" name="upload">
        </fieldset>
    </form>
<?php endif; ?>
<?php if (isset($_POST['upload'])): ?>
    <h1>Служебная информация:</h1>
    <pre>
        <?php print_r($_FILES); ?>
    </pre>
 <?php endif; ?>
    <div>
        <fieldset>
            <a href="list.php">Посмотреть все тесты >></a>
        </fieldset>
    </div>
</body>
</html>
