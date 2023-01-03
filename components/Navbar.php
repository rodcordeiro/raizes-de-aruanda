<?php

function NavBar(array $menuList)
{
    $list = "";
    foreach ($menuList as $menu) {
        $list .= "<li><a href='" . $menu['url'] . "'>" . $menu['name'] . "</a></li>\n";
    }
    echo $list;
}
