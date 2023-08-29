<?php

namespace Application\Controllers;

use App\Services\SessionService;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Application\Lib\DatabaseConnection;
use Application\Repository\PostRepository;
use Application\Repository\CommentRepository;
use Application\Controllers\DefaultController;
use Twig\Environment;

class PostController extends DefaultController
{
    private $connection;
    private $repository;
    private $sessionService;
    public function __construct()
    {
        $this->connection = DatabaseConnection::getConnection();
        $this->repository = new PostRepository();
      //  $this->sessionService= new SessionService();
    }
    public function show(string $identifier)
    {
       
        $post = $this->repository->getPost($identifier);

        $commentRepository = new CommentRepository();
        $comments = $commentRepository->getComments($identifier);
        $param=array("post" => $post);
        $this->render("posts/show.html.twig", $param, false);
        
       
        
    }
    public function index()
    {
        $connection =  DatabaseConnection::getConnection();
        $postRepository = new PostRepository();
        $posts = $postRepository->getPosts();
          $param=array("posts" => $posts );
        $this->render("posts/listPosts.html.twig", $param, false);
    }
    public function createPostMethod()
    {
        $this->session->isAdmin();

        $twigPage = 'createPost.html.twig';

        $post = $this->post->getPostArray();

        if (!empty($post)) {
            $verify = $this->post->verifyPost();
            if ($verify !== true) {
                return $this->renderTwigErr($twigPage, $verify);
                //return $this->render('createArticle.twig', ['erreur' => $verify]); /
            }
            $this->articleSql->createArticle($post['title'], $post['content'], $post['chapo'], $this->session->getUserVar('idUser'));

            return $this->renderTwigSuccess($twigPage, 'Votre article nous a bien été envoyé! Il ne manque plus qu\'à le valider!');
        } elseif (empty($post)) {

            return $this->render($twigPage);
        }
        //$this->redirect('blog&method=createArticle');
    }

    
}
