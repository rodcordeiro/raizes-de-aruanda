<?php

function NavBar(array $menuList)
{
    $list = "";
    foreach ($menuList as $menu) {
        $classList = 'item';
        if (isset($_GET['search']) and $_GET['search'] == $menu['id']) {
            $classList .= ' active';
        }
        $list .= "<li class='" . $classList . "'><a href='?search=" . $menu['id'] . "'>" . $menu['linha'] . "</a></li>\n";
    }
    echo $list;
}
