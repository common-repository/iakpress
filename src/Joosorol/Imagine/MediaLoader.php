<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\Imagine;

use App\Joosorol\IAKPress\IAPost\PostUtils;
use Liip\ImagineBundle\Binary\MimeTypeGuesserInterface;


use Liip\ImagineBundle\Binary\Loader\FileSystemLoader;
use Liip\ImagineBundle\Binary\Locator\LocatorInterface;
use Liip\ImagineBundle\Model\FileBinary;
use Liip\ImagineBundle\Exception\Binary\Loader\NotLoadableException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesserInterface as DeprecatedExtensionGuesserInterface;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesserInterface as DeprecatedMimeTypeGuesserInterface;
use Symfony\Component\Mime\MimeTypesInterface;

class MediaLoader extends FileSystemLoader
{
    protected $dataDir;
    protected $dataUrl;


    /**
     * @param MimeTypeGuesserInterface|DeprecatedMimeTypeGuesserInterface $mimeGuesser
     * @param MimeTypesInterface|DeprecatedExtensionGuesserInterface      $extensionGuesser
     * @param LocatorInterface      $locator
     */
    public function __construct(
        $mimeTypeGuesser,
        $extensionGuesser,
        $locator
    ) {
        parent::__construct($mimeTypeGuesser, $extensionGuesser, $locator);
        $this->dataDir = PostUtils::getInstance()->getDataDir();
        $this->dataUrl = PostUtils::getInstance()->getDataUrl();
    }

    public function find($path)
    {
        if (false !== strpos($path, '../')) {
            throw new NotLoadableException(sprintf("Source image was searched with '%s' out side of the defined root path", $path));
        }

        $absolutePath = $this->dataDir.'/'.ltrim($path, '/');

        if (false == file_exists($absolutePath)) {
            throw new NotLoadableException(sprintf('Source image not found in "%s"', $absolutePath));
        }

        $file = new File($absolutePath);

        
        $mimeType = $file->getMimeType();

        $format = $file->getExtension();

        return new FileBinary(
            $absolutePath,
            $mimeType,
            $format
        );
    }
}