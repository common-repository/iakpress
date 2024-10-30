<?php

/*
 * This file is part of the IAKPress package.
 *
 * (c) IAKPress <contact@iakpress.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\IAPost;

/**
 * class ListItemCssClasses
 */
class ListItemCssClasses
{
    const CSS_CLASSES = [
        'li_a_item_class' => ['LI. class', '.iak-a-item'],
        'li_a_item_body_class' => ['LI. body class', '.iak-a-item-body'],
        'li_a_selected_item_class' => ['LI. selected class', '.iak-a-item-selected'],
        'li_a_hover_item_class' => ['LI. hover class', '.iak-a-item-hover'],
        'li_a_img_class' => ['LI. image class', '.iak-a-img'],
        'li_a_img_hover_class' => ['LI. image hover class', '.iak-a-img-hover'],
        'li_a_info_class' => ['LI. archive info class', '.iak-a-info'],
        'li_a_title_class' => ['LI. archive title class', '.iak-a-title'],
        'li_a_link_class' => ['LI. archive link class', '.iak-a-link'],
        'li_a_price_class' => ['LI. archive price class', '.iak-a-price'],
        'li_s_title_class' => ['LI. single title class', '.iak-s-title'],
        'li_s_price_class' => ['LI. single price class', '.iak-s-price'],
        'li_s_short_desc_class' => ['LI. excerpt class', '.iak-s-short-desc'],
        'li_s_desc_class' => ['LI. content class', '.iak-s-desc']
    ];


    /**
     * Constructor.
     */
    private function __construct()
    {
    }
}
