<?php
 
namespace App\Joosorol\IAKPress\DependencyInjection;
 
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
 
/**
 * Loads bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class IAKPressExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        //$configuration = new Configuration();
        //$config = $this->processConfiguration($configuration, $configs);
 
        /*$loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Medias/config/'));
        $loader->load('iaPOST_CONFIG_admin.xml');*/
    }
}
