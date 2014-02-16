<?php

/*
 * This file is part of the BGBarcodeBundle package.
 *
 * (c) Patrick Paechnatz <https://github.com/paterik>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BG\BarcodeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Patrick Paechnatz, https://github.com/paterik
 */
class BarcodeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
