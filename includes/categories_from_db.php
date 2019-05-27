<?php

    $res = [];
    
    $cats = mysqli_query($link, "SELECT * FROM categories");
    $categoryChilds = mysqli_query($link, "SELECT * FROM category_child");

    $categories = [];
    $ids = [];

    while ($cat = mysqli_fetch_assoc($cats)) {
        $categories[$cat['id']] = $cat;
        $ids[] = $cat['id'];
    }

    $handledCategoryChilds = [];
    while ($c = mysqli_fetch_assoc($categoryChilds)) {
        $handledCategoryChilds[] = $c;
        if (($key = array_search($c['id_child'], $ids)) != NULL) {
            unset($ids[$key]);
        }
    }

    function getChildrenIds($id) {
        global $handledCategoryChilds;
        $result = [];
        foreach ($handledCategoryChilds as $c) {
            if ($c['id_category'] == $id) {
                $result[] = $c['id_child'];
            }
        }
        return $result;
    }

    function formNestedNavigation($id, $offset, $path, $depth) {
        global $categories;
        global $res;
        foreach (getChildrenIds($id) as $child) {
            $res[] = [$offset, $categories[$child]['name'], $path.$categories[$child]['alias'], $depth + 1];
            formNestedNavigation($child, $offset + 4, $path.$categories[$child]['alias'], $depth + 1);
        }
    }

    function getOneLevelOfNesting($val) {
        return $val[3] <= 1;
    }

    foreach ($ids as $id) {
        $res[] = [0, $categories[$id]['name'], $categories[$id]['alias'], 0];
        formNestedNavigation($id, 4, $categories[$id]['alias'], 0);
    }
    
    $oneLevelNested = array_filter($res, "getOneLevelOfNesting");

?>