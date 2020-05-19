<?php
/**
 * This software belongs to Dennis Barlowe (Aschaffenburg, Germany) and is copyrighted.
 *
 * Any unauthorized use of this software without having a valid license
 * violates the license agreement and will be prosecuted by the proper authorities.
 *
 * Creator: dbarlowe
 * Date: 18.05.20 - 20:50
 *
 * @link https://www.dennzo.com
 * @copyright 2020 Dennis Barlowe
 */

namespace Dennzo\WordpressHelper\MetaFieldCreator\Field;

use Dennzo\WordpressHelper\MetaFieldCreator\AbstractMetaField;

class TextField extends AbstractMetaField
{
    /**
     * @inheritDoc
     */
    public function html(): void
    {
        global $post;
        $value = get_post_meta($post->ID, $this->metaKey, true);

        ?>

        <label for="<?php echo $this->metaKey; ?>"><?php echo $this->metaFieldDescription ?></label><br>
        <input id="<?php echo $this->metaKey; ?>" name="<?php echo $this->metaKey; ?>" type="text" value="<?php echo $value ?>"><br>
        <?php
    }
}
