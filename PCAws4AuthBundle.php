<?php

/*
 * This file is part of the Symfony2 Aws4AuthBundle.
 *
 * (c) Peter Culka
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PC\Aws4AuthBundle;

use PC\Aws4AuthBundle\DependencyInjection\Security\Factory\Aws4Factory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * AWS Signature 4 Authentication Bundle
 */
class PCAws4AuthBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new Aws4Factory());
    }
}
