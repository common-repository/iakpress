<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\Imagine;

use App\Joosorol\IAKPress\IAPost\PostUtils;
use Liip\ImagineBundle\Imagine\Cache\Resolver\WebPathResolver;

class RemoteCacheResolver extends WebPathResolver
{

      /**
     * {@inheritdoc}
     */
    public function resolve($path, $filter)
    {
        return sprintf('%s/%s',
            rtrim(PostUtils::getInstance()->getDataUrl(), '/'),
            ltrim($this->getFileUrl($path, $filter), '/')
        );
    }
}
