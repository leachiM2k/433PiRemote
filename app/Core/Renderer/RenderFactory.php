<?php
/**
 * Created by IntelliJ IDEA.
 * User: rotmanov
 * Date: 29.04.17
 * Time: 13:04
 */

namespace Core\Renderer;

class RenderFactory
{
    function __construct($renderConfig = null)
    {
        $this->renderConfig = $renderConfig;
    }

    public function getRenderer()
    {
        $name = strtolower($this->renderConfig['renderer']);

        switch ($name) {
            case 'twig':
                return new TwigRenderer($this->renderConfig);
                break;
        }
        throw new \RuntimeException('Can not instantiate unknown renderer ' . $name);
    }

}