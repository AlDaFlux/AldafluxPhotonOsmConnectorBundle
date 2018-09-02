<?php

namespace Schoenef\PhotonOsmConnectorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PhotonOsmConnectorBundle extends Bundle
{
    public function build(ContainerBuilder $container) {
        parent::build($container);
    }
}