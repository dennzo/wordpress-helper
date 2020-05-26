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

namespace Dennzo\WordpressHelper\MetaFieldCreator;

use Dennzo\WordpressHelper\Model\MetaGroupParameters;

class MetaGroup
{
    /**
     * @var MetaGroupParameters
     */
    private $parameters;

    /**
     * @var MetaFieldInterface[]|array
     */
    private $metaFields;

    public function __construct(MetaGroupParameters $parameters)
    {
        $this->parameters = $parameters;


        // First add the custom boxes
        add_action('add_meta_boxes', [
            $this,
            'add'
        ]);

        // Then add the save action
        add_action('save_post', [
            $this,
            'save'
        ]);
    }

    /**
     * @return void
     */
    public function add(): void
    {
        add_meta_box(
            $this->parameters->getPostTypeSlug() . '_' . $this->parameters->getMetaGroupName(),
            __($this->parameters->getMetaGroupDescription(), $this->parameters->getDomain()),
            [$this, 'html'],
            $this->parameters->getPostTypeSlug(),
            $this->parameters->getPosition()
        );
    }

    /**
     * @param MetaFieldInterface $metaField
     * @return MetaGroup
     */
    public function addMetaField(MetaFieldInterface $metaField): MetaGroup
    {
        $this->metaFields[] = $metaField;

        return $this;
    }

    /**
     * @param integer $postID
     * @return void
     */
    public function save(int $postID): void
    {
        foreach ($this->metaFields as $metaField) {
            if (array_key_exists($metaField->getMetaKey(), $_POST)) {
                update_post_meta($postID, $metaField->getMetaKey(), $_POST[$metaField->getMetaKey()]);
            }
        }
    }

    public function html()
    {
        foreach ($this->metaFields as $metaField) {
            $metaField->html();
        }
    }

}
