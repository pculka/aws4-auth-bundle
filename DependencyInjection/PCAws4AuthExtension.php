<?php

namespace PC\Aws4AuthBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class PCAws4AuthExtension extends Extension
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * Loads a specific configuration.
     *
     * @param array $configs An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->container = $container;

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        foreach ($config as $key => $value) {
            $this->parseNode('pc_aws4_auth.' . $key, $value);
        }

        $container->setParameter('pc_aws4_auth', $config);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');
        
        $loader->load('access_keys.yml');
//        if (!empty($config['access_keys'])) {
//
//        }


    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @throws \Exception
     */
    protected function parseNode($name, $value)
    {
        if (is_string($value)) {
            $this->set($name, $value);

            return;
        }
        if (is_integer($value)) {
            $this->set($name, $value);

            return;
        }
        if (is_array($value)) {
            foreach ($value as $newKey => $newValue) {
                $this->parseNode($name . '.' . $newKey, $newValue);
            }

            return;
        }
        if (is_bool($value)) {
            $this->set($name, $value);

            return;
        }
        throw new \Exception(gettype($value) . ' not supported');
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    protected function set($key, $value)
    {
        $this->container->setParameter($key, $value);
    }
}
