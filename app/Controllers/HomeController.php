<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/app/Core/Response.php';


class HomeController
{

    protected Response $response;

    public function __construct()
    {
        $this->index();
    }

    public function index()
    {
        $title = "You are at the main page!";
        $breadcrumbs = [
            'title' => "Home page",
            'link' => "/",
        ];
        $content = render("index", compact("title", "breadcrumbs"));

        $this->response = new Response($content);
        $this->response->send();
    }
}