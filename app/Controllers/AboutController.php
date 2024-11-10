<?php

    $title = "About subtitle";
    $breadcrumbs =[
        'title' => "About",
        'link' => "/about",
    ];
    echo render("about", compact("title", "breadcrumbs"));