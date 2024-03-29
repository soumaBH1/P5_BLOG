<?php

namespace Application\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class DefaultController
{
    /**
     * Summary of render
     * @param string $templateFile
     * @param array $params
     * @param bool $isDebug
     * @return void
     */
    public function render(string $templateFile, array $params = [], bool $isDebug = false)
    {
        $loader = new FilesystemLoader("templates");
        if ($isDebug) {
            $twig = new Environment($loader, ['debug' => true]);
        }else{
            $twig = new Environment($loader);
        }

        $twig->addExtension(new DebugExtension());
        // load template
        $template = $twig->load($templateFile);
        // set template variables
         echo $template->render($params);
    }
}
