<?php

$title = "Contact subtitle";
$breadcrumbs =[
    'title' => "Contact",
    'link' => "/contact",
];
echo render("contact", compact("title", "breadcrumbs"));