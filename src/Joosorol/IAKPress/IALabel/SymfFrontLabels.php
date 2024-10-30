<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) IAKPress <contact@iakpress.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace  App\Joosorol\IAKPress\IALabel;

use App\Joosorol\IAKPress\IAPost\Constants;
use Exception;

/**
 * class SymfFrontLabels
 */
class SymfFrontLabels implements Labels
{
    public function getLabels(): array
    {
        return [
        ];
    }

    public function getLabelByKey(string $key, string $defaultValue = null) : string {
        throw new Exception(Constants::NOT_IMPLEMENTED_ERROR);
    }
}
