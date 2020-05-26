<?php
/**
 * Wordpress Helper Tools
 *
 * @copyright 2020 - Dennzo (Dennis Barlowe)
 * @link https://www.dennzo.com
 *
 * This program  is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
