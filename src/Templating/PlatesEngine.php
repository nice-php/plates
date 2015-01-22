<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Nice\Templating;

use League\Plates\Engine;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Templating\TemplateReferenceInterface;

class PlatesEngine implements EngineInterface
{
    /**
     * @var Engine
     */
    private $plates;

    /**
     * @var TemplateNameParserInterface
     */
    private $parser;

    /**
     * Constructor
     *
     * @param Engine                      $plates
     * @param TemplateNameParserInterface $parser
     */
    public function __construct(Engine $plates, TemplateNameParserInterface $parser)
    {
        $this->plates = $plates;
        $this->parser = $parser;
    }

    /**
     * @param string|TemplateReferenceInterface $name
     * @param array                             $parameters
     *
     * @return string
     */
    public function render($name, array $parameters = array())
    {
        return $this->plates->render($name, $parameters);
    }

    /**
     * @param string|TemplateReferenceInterface $name
     *
     * @return bool
     */
    public function exists($name)
    {
        return $this->plates->exists($name);
    }

    /**
     * @param string|TemplateReferenceInterface $name
     *
     * @return bool
     */
    public function supports($name)
    {
        $template = $this->parser->parse($name);

        return $this->plates->getFileExtension() === $template->get('engine');
    }
}
