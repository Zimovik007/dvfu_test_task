<?php
    use yii\helpers\Html;
    $this->title = 'Тестовое задание';
?>
<h3>Навигация</h3>
<?php
    foreach ($categories as $nav) {
        printf("<p>%s%s %s</p>", str_repeat("&nbsp;&nbsp;", $nav[0]), $nav[1], $nav[2]);
    }
?>

<h4>Один уровень вложенности</h4>
<?php
    foreach ($oneLevelNestedCategories as $nav) {
        printf("<p>%s%s</p>", str_repeat("&nbsp;&nbsp;", $nav[0]), $nav[1]);
    }
?>