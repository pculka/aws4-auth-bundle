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
    }
}
