<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Nice\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Sets up Plates services
 */
class PlatesExtension extends Extension
{
    /**
     * @var string
     */
    protected $templateDir;

    /**
     * Constructor
     *
     * @param string $templateDir
     */
    public function __construct($templateDir)
    {
        $this->templateDir = $templateDir;
    }

    /**
     * Loads a specific configuration
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $container->setParameter('plates.template_dir', $this->templateDir);

        $container->register('plates', 'League\Plates\Engine')
            ->setPublic(false)
            ->addArgument('%plates.template_dir%');

        $container->register('templating.engine.plates', 'Nice\Templating\PlatesEngine')
            ->addArgument(new Reference('plates'))
            ->addArgument(new Reference('templating.template_name_parser'))
            ->addTag('templating.engine');
    }
}
