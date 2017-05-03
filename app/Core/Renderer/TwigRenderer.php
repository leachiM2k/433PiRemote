<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 13:23
 */

namespace Core\Renderer;

use Core\Dispatcher\ResponseEntity;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigRenderer
{
    private $path = '';
    private $debug = false;

    public function __construct($renderConfig)
    {
        ['path' => $this->path, 'debug' => $this->debug] = $renderConfig;
        $this->twig = $this->getTwig();
    }

    private function getTwig()
    {
        $twigTemplates = new Twig_Loader_Filesystem($this->path . '/templates');
        $twig = new Twig_Environment($twigTemplates, array(
            'cache' => $this->path . '/cache',
            'debug' => $this->debug,
        ));
        return $twig;
    }

    public function render(ResponseEntity $response)
    {
        $templateName = $response->getTemplate();
        if (!preg_match('/.html.twig$/', $templateName)) {
            $templateName .= '.html.twig';
        }
        return $this->twig->render($templateName, $response->getPayload());
    }
}