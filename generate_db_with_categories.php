<?php

    $json = json_decode(file_get_contents("categories.json"), true)['categories'];

    $link = mysqli_connect('localhost', 'root', '');

    mysqli_query($link, "DROP DATABASE cats");
    mysqli_query($link, "CREATE DATABASE cats");
    mysqli_query(
        $link, 
        "CREATE TABLE cats.categories (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, id_category INT, name VARCHAR(255), alias VARCHAR(255))"
    );
    mysqli_query(
        $link, 
        "CREATE TABLE cats.category_child (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, id_category INT, id_child INT)"
    );

    foreach ($json as $elem) {
        $stmt = mysqli_prepare(
            $link, 
            "INSERT INTO cats.categories (id_category, name, alias) VALUES (?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "iss", $elem['id'], $elem['name'], $elem['alias']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        foreach ($elem['children'] as $child) {
            $stmt = mysqli_prepare(
                $link, 
                "INSERT INTO cats.category_child (id_category, id_child) VALUES (?, ?)"
            );
            mysqli_stmt_bind_param($stmt, "ii", $elem['id'], $child);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }    

    mysqli_close($link);

?>