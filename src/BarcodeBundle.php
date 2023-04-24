<?php

declare(strict_types=1);

namespace TomasVotruba\BarcodeBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class BarcodeBundle extends Bundle
{
    public function build(ContainerBuilder $containerBuilder): void
    {
        parent::build($containerBuilder);
    }
}
