<?
namespace Application\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Application\Lib\DatabaseConnection;
use Application\Services\SessionService;
use Application\Repository\PostRepository;
use Application\Repository\UserRepository;
use Application\Repository\CommentRepository;
use Application\Controllers\DefaultController;

class AdminController extends DefaultController
{
    
    public function execute()
    {
        
        $sessionService=new SessionService();
        $userSession=$sessionService->getUserArray();
      
       $postRepository = new PostRepository();
       $posts = $postRepository->getPosts();

       $userRepository = new UserRepository();
        $users = $userRepository->getUsers();

        $commentRepository = new CommentRepository();
        $comments = $commentRepository->getAllComments();
        
        $params = array("comments" => $comments,"posts" => $posts, "users" => $users, "userSession" => $userSession);
       $this->render("adminDashboard.html.twig", $params);

    }
}
