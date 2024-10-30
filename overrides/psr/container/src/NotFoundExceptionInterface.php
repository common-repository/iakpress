<?php

namespace Psr\Container;

if (!interface_exists(' Psr\Container\NotFoundExceptionInterface')) :

/**
 * No entry was found in the container.
 */
interface NotFoundExceptionInterface extends ContainerExceptionInterface
{
}

endif;