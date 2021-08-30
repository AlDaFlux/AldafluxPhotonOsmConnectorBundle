<?php

namespace Aldaflux\AldafluxPhotonOsmConnectorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

  const KEY_TIMEOUT = 'timeout';
    const KEY_API_HOST = 'host';
    const KEY_LANG = 'lang';

    const API_HOST_DEFAULT = 'https://photon.komoot.io/api/';

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('aldaflux_photon_osm_connector');
        $rootNode = $treeBuilder->getRootNode();
	
        $rootNode
            ->children()
                ->enumNode(self::KEY_LANG)->values(['en', 'de', 'fr', 'es', 'ru'])->defaultValue('en')->end()
                ->scalarNode(self::KEY_API_HOST)->defaultValue(self::API_HOST_DEFAULT)->end()
                ->integerNode(self::KEY_TIMEOUT)->defaultValue(20)->end()
            ->end();

        return $treeBuilder;
    }


}
