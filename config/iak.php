<?php

use App\Joosorol\IAKPress\IAPost\PostUtils;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator)  {
    $parameters = $containerConfigurator->parameters();

    $parameters->set("iak_data_dir", PostUtils::getInstance()->getDataDir());
    $parameters->set("iak_data_url", PostUtils::getInstance()->getDataUrl());
    $parameters->set("iak_secret", PostUtils::getInstance()->getSecret());
};