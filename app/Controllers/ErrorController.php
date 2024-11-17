<?php

declare(strict_types=1);

class ErrorController
{

    public function __construct()
    {
        $this->index();
    }

    public function index()
    {
        $title = "We couldn't find a page with that name";

        echo render("error", compact("title"));
    }
}
