<?php
// src/Kernel.php
namespace App;

use App\Joosorol\WP\IAModel\AttchmentModel;
use App\Joosorol\WP\IAModel\GenericEntryModel;
use App\Joosorol\IAKPress\IAPost\PostUtils;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private bool $isBooted = false;

    public function __construct(string $environment, bool $debug)
    {
        parent::__construct($environment, $debug);
    }
    

    public function registerBundles(): array
    {
        $bundles = [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle()
        ];

        if (PostUtils::getInstance()->hasGd()) {
            $bundles[] = new \Liip\ImagineBundle\LiipImagineBundle();
        }

        if ($this->getEnvironment() == 'dev') {
            $bundles[] = new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    protected function configureContainer(ContainerConfigurator $c): void
    {
        $c->import(__DIR__.'/../config/framework.yaml');

        $c->import(__DIR__.'/../config/iak.php');
        

        if (PostUtils::getInstance()->hasGd()) {
            $c->import(__DIR__.'/../config/services.xml');
            $c->import(__DIR__.'/../config/liip.yaml');
        }


        // register all classes in /src/ as service
        $c->services()
            ->load('App\\', __DIR__.'/*')
            ->autowire()
            ->autoconfigure()
        ;

        // configure WebProfilerBundle only if the bundle is enabled
        /*if (isset($this->bundles['WebProfilerBundle'])) {
            $c->extension('web_profiler', [
                'toolbar' => true,
                'intercept_redirects' => false,
            ]);
        }

        // configure the database
        $c->extension('doctrine', [
            'dbal' => [
                // by convention the env var names are always uppercase
                'url' =>  sprintf(
                    "mysql://%s:%s@%s/%s",
                    DB_USER,
                    DB_PASSWORD,
                    DB_HOST,
                    DB_NAME)
            ]
        ]);*/
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        // import the WebProfilerRoutes, only if the bundle is enabled
        if (isset($this->bundles['WebProfilerBundle'])) {
            $routes->import('@WebProfilerBundle/Resources/config/routing/wdt.xml')->prefix('/_wdt');
            $routes->import('@WebProfilerBundle/Resources/config/routing/profiler.xml')->prefix('/_profiler');
        }


        // load the annotation routes
        $routes->import(__DIR__.'/Joosorol/IAKPress/Controller/', 'annotation');
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if (false == $this->isBooted) {
            parent::boot();

            $this->isBooted  = true;
    
            if (PostUtils::getInstance()->hasGd()) {
                $service = $this->getContainer()->get("iak.image.filter");
                GenericEntryModel::setImageFilter($service);
                AttchmentModel::setImageFilter($service);
            }
        }
    }

    public function getIsBooted() : bool {
        return $this->isBooted;
    }

    // optional, to use the standard Symfony cache directory
    public function getCacheDir(): string
    {
        return __DIR__.'/../var/cache/'.$this->getEnvironment();
    }

    // optional, to use the standard Symfony logs directory
    public function getLogDir(): string
    {
        return __DIR__.'/../var/log';
    }
}