<?php

    $link = mysqli_connect('localhost', 'root', '', 'cats');

    $rows = mysqli_query($link, "SELECT * FROM categories");

    while ($row = mysqli_fetch_assoc($rows)) {
        echo $row['name'].' '.$row['alias'].PHP_EOL;
    }

?>