<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\Imagine;


use Liip\ImagineBundle\Imagine\Cache\Helper\PathHelper;
use Liip\ImagineBundle\Service\FilterService;


use App\Joosorol\IAKPress\IAPost\IAFieldType\Common\Option;
use App\Joosorol\IAKPress\IAPost\PostUtils;


/**
 * Description of ImageFilter
 *
 * @author bly
 */
class ImageFilter {
    const THUMBNAIL_FILTER = "iakthumbnail";
    const LARGE_FILTER = "iakprodimg";


    /**
     * @var FilterService
     */
    private $filterService;


    public function __construct(FilterService $filterService) {
        $this->filterService = $filterService;
    }


    public function getThumbnailImageUrl(int $formId, string $path, string $defaultUrl) {
        $width = PostUtils::getInstance()->getPostMeta($formId, Option::THUMBNAIL_IMAGE_WIDTH, true);
        $theWidth = intval(empty($width) ? 150 : $width);

        $height = PostUtils::getInstance()->getPostMeta($formId, Option::THUMBNAIL_IMAGE_HEIGHT, true);
        $theHeight = intval(empty($height) ? 150 : $height);

        $path = PathHelper::urlPathToFilePath($path);
        $runtimeConfig = [
            'thumbnail' => [
                'size' => [ $theWidth,  $theHeight]
            ],
        ];

        
        return $this->doGetUrlOfFilteredImageWithRuntimeFilters($runtimeConfig, self::THUMBNAIL_FILTER, $path, $defaultUrl);
    }

    public function getLargeImageUrl(int $formId, string $path, string $defaultUrl) {
        $width = PostUtils::getInstance()->getPostMeta($formId, Option::LARGE_IMAGE_WIDTH, true);
        $theWidth = intval(empty($width) ? 600 : $width);

        $height = PostUtils::getInstance()->getPostMeta($formId, Option::LARGE_IMAGE_HEIGHT, true);
        $theHeight = intval(empty($height) ? 799 : $height);

        $path = PathHelper::urlPathToFilePath($path);
        $runtimeConfig = [
            'thumbnail' => [
                'size' => [ $theWidth,  $theHeight]
            ],
        ];
        
        return $this->doGetUrlOfFilteredImageWithRuntimeFilters($runtimeConfig, self::LARGE_FILTER, $path, $defaultUrl);
    }


    protected function doGetUrlOfFilteredImageWithRuntimeFilters(array $runtimeConfig, string $filter, string $path, string $defaultUrl) {
        if (!PostUtils::getInstance()->isGdLoaded()) {
            return $defaultUrl;
        }

        $path = PathHelper::urlPathToFilePath($path);
  
        return $this->filterService->getUrlOfFilteredImageWithRuntimeFilters(
            $path,
            $filter,
            $runtimeConfig,
            null,
            PostUtils::getInstance()->getIsWebpSupported()
        );
    }
}
