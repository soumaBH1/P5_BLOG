<?php

namespace Application\Controllers;

//require_once('src/lib/database_connection.php');
//require_once('src/model/post.php');
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Application\Lib\DatabaseConnection;
use Application\Repository\PostRepository;
use Application\Controllers\DefaultController;
use Application\Services\SessionService;

class HomepageController extends DefaultController
{
    /**
     * Summary of execute
     * @return void
     */
    public function execute()
    {

        $connection =  DatabaseConnection::getConnection();
        $sessionService = new SessionService();

        $userSession = $sessionService->getUserArray();

        $this->render("homepage.html.twig", ["userSession" => $userSession]);
    }
}
