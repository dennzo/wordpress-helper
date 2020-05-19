<?php
/**
 * This software belongs to Dennis Barlowe (Aschaffenburg, Germany) and is copyrighted.
 *
 * Any unauthorized use of this software without having a valid license
 * violates the license agreement and will be prosecuted by the proper authorities.
 *
 * Creator: dbarlowe
 * Date: 18.05.20 - 20:53
 *
 * @link https://www.dennzo.com
 * @copyright 2020 Dennis Barlowe
 */

namespace Dennzo\WordpressHelper\MetaFieldCreator;

abstract class AbstractMetaField implements MetaFieldInterface
{
    /**
     * @var string
     */
    protected $metaFieldDescription, $metaKey;

    /**
     * WYSIWYG constructor.
     * @param string $metaKey Name of the meta field.
     * @param string $metaFieldDescription Label that should be shown for the field.
     */
    public function __construct(string $metaKey, string $metaFieldDescription)
    {
        $this->metaFieldDescription = $metaFieldDescription;
        $this->metaKey = $metaKey;
    }

    /**
     * @return void
     */
    abstract function html(): void;

    /**
     * @inheritDoc
     */
    public function getMetaKey(): string
    {
        return $this->metaKey;
    }
}
