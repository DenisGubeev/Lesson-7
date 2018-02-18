<?php

if (!isset(glob('tests/*.json')[$_GET['number']])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}

$alltests = glob('tests/*.json');
$number = $_GET['number'];
$test = file_get_contents($alltests[$number]);
$test = json_decode($test, true);
if (isset($_POST['check-test'])) {
    function checktest($myfile) {
        $i = 0;
        $questions = 0;
        foreach ($myfile as $key => $item) {
            $questions++;
            if ($item['correct_answer'] === $_POST['answer' . $key]) {
                $i++;
                $infoStyle = 'correct';
            } else {
                $infoStyle = 'incorrect';
            }
            echo '<div <div style="border-bottom: 2px solid grey; padding:10px 5px;">';
            echo 'Вопрос: ' . $item['question'] . '<br>';
            echo 'Ваш ответ: ' . $item['answers'][$_POST['answer' . $key]] . '<br>';
            echo '<i>Правильный ответ: </i>' . $item['answers'][$item['correct_answer']] . '<br>';
            echo '</div>';
            echo '<hr>';
        }
    }
}

function сounter($myfile)
{
    $i = 0;
    $questions = 0;
    foreach ($myfile as $key => $item) {
        $questions++;
        if ($item['correct_answer'] === $_POST['answer' . $key]) {
            $i++;
        }
    }
    return ['correct' => $i, 'total' => $questions];
}
if (isset($_POST['check-test'])) {
    $testname = basename($alltests[$number]);
    $username = str_replace(' ', '', $_POST['username']);
    $date = date("d-m-Y");
    $correctanswers = сounter($test)['correct'];
    $totalanswers = сounter($test)['total'];
    $variables = [
        'testname' => $testname,
        'username' => $username,
        'date' => $date,
        'correctanswers' => $correctanswers,
        'totalanswers' => $totalanswers
    ];
}
if (isset($_POST['picture'])) {
    include 'picture.php';
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>
<body>
    <a href="<?php echo isset($_POST['check-test']) ? $_SERVER['HTTP_REFERER'] : 'list.php' ?>"><div>Назад</div></a><br>
	<?php if (isset($_GET['number']) && !isset($_POST['check-test'])): ?>
        <form method="POST">
            <h1><?php echo basename($alltests[$number]); ?></h1>
            <?php foreach($test as $key => $item):  ?>
            <fieldset>
                <legend><?php echo $item['question'] ?></legend>
                <label><input type="radio" name="answer<?php echo $key ?>" value="0"><?php echo $item['answers'][0] ?></label><br>
                <label><input type="radio" name="answer<?php echo $key ?>" value="1"><?php echo $item['answers'][1] ?></label><br>
                <label><input type="radio" name="answer<?php echo $key ?>" value="2"><?php echo $item['answers'][2] ?></label><br>
                <label><input type="radio" name="answer<?php echo $key ?>" value="3"><?php echo $item['answers'][3] ?></label>
            </fieldset>
            <?php endforeach; ?>
            <input type="submit" name="check-test" value="Проверить">
        </form>
    <?php endif; ?>
    
    <?php if (isset($_POST['check-test'])): ?>
    <div class="check-test">
        <?php checkTest($test) ?>
        <p style="font-weight: bold;">Правильных ответов: <?php echo "$correctanswers из $totalanswers" ?></p>
        <h2>Для генерации сертификата, <?php echo $username ?>: </h2>
        <form method="POST">
            <input type="submit" name="picture" value="Генерация">
            <?php foreach ($variables as $key => $variable): ?>
                <input type="hidden" value="<?php echo $variable ?>" name="<?php echo $key ?>">
            <?php endforeach; ?>
        </form>
    </div>
<?php endif; ?>
    </div>

</body>
</html>
