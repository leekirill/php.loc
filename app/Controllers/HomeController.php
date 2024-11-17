<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/app/Core/Response.php';
require_once dirname(__DIR__, 2) . '/app/db/Connection.php';

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

        $config = require dirname(__DIR__, 2) . '/config/db.php';

        $pdo = Connection::make($config['database']);

        $sql = 'SELECT * FROM feedback, brands, categories, badges, tags';

        $statement = $pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll();

        $content = render("index", compact("title", "breadcrumbs"));

        $this->response = new Response($content);
        $this->response->send();

        var_export($results);
    }
}