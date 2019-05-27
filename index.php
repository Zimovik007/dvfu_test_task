<?php include('includes/connection_to_db.php'); ?>
<?php include('includes/categories_from_db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DVFU</title>
</head>
<body>
    
    <h3>Навигация</h3>
    <?php
        foreach ($res as $nav) {
            printf("<p>%s%s %s</p>", str_repeat("&nbsp;", $nav[0]), $nav[1], $nav[2]);
        }
    ?>

    <h4>Один уровень вложенности</h4>
    <?php
        foreach ($oneLevelNested as $nav) {
            printf("<p>%s%s</p>", str_repeat("&nbsp;", $nav[0]), $nav[1]);
        }
    ?>
</body>
</html>
