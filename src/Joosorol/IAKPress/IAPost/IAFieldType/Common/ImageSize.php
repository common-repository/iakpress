<?php

/*
 * This file is part of Joosorol package.
 * 
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Joosorol\IAKPress\IAPost\IAFieldType\Common;


class ImageSize {
    /**
     * Constructor
     */
    private function __construct() {
    }


    const SMALL = 1;
    const SMALL_LABEL = 'Thumbnail';

    const MEDIUM = 2;
    const MEDIUM_LABEL = 'Medium';

    const LARGE = 3;
    const LARGE_LABEL = 'Large';

    const FULL = 4;
    const FULL_LABEL = 'Full';
}