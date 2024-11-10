<?php

    $title = "You are at the main page!";
    $breadcrumbs =[
        'title' => "Home page",
        'link' => "/",
    ];
    echo render("index", compact("title", "breadcrumbs"));