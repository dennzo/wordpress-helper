<?php
/**
 * This software belongs to Dennis Barlowe (Aschaffenburg, Germany) and is copyrighted.
 *
 * Any unauthorized use of this software without having a valid license
 * violates the license agreement and will be prosecuted by the proper authorities.
 *
 * Creator: dbarlowe
 * Date: 18.05.20 - 21:11
 *
 * @link https://www.dennzo.com
 * @copyright 2020 Dennis Barlowe
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
