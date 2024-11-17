<?php

declare(strict_types=1);

class AboutController
{

    public function __construct()
    {
        $this->index();
    }

    public function index()
    {
        $title = "About subtitle";
        $breadcrumbs = [
            'title' => "About",
            'link' => "/about",
        ];
        echo render("about", compact("title", "breadcrumbs"));
    }
}