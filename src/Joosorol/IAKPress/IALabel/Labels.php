<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) IAKPress <contact@iakpress.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IALabel;


/**
 * class Labels
 */
interface Labels
{

    public function getLabels(): array;

    function getLabelByKey(string $key, string $defaultValue = null) : string;
}
