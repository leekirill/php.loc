<?php

declare(strict_types=1);

class ContactController
{

    public function __construct()
    {
        $this->index();
    }

    public function index()
    {
        $title = "Contact subtitle";
        $breadcrumbs = [
            'title' => "Contact",
            'link' => "/contact",
        ];
        echo render("contact", compact("title", "breadcrumbs"));
    }
}