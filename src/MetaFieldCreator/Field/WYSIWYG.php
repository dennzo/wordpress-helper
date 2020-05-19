<?php
/**
 * This software belongs to Dennis Barlowe (Aschaffenburg, Germany) and is copyrighted.
 *
 * Any unauthorized use of this software without having a valid license
 * violates the license agreement and will be prosecuted by the proper authorities.
 *
 * Creator: dbarlowe
 * Date: 18.05.20 - 20:43
 *
 * @link https://www.dennzo.com
 * @copyright 2020 Dennis Barlowe
 */

namespace Dennzo\WordpressHelper\MetaFieldCreator\Field;

use Dennzo\WordpressHelper\MetaFieldCreator\AbstractMetaField;

class WYSIWYG extends AbstractMetaField
{
    /**
     * @inheritDoc
     */
    public function html(): void
    {
        global $post;
        $value = get_post_meta($post->ID, $this->metaKey, true);

        wp_editor(
            htmlspecialchars_decode($value),
            $this->metaKey,
            ['textarea_name' => $this->metaKey]
        );
        ?> <br> <?php
    }
}
