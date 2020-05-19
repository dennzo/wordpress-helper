<?php
/**
 * This software belongs to Dennis Barlowe (Aschaffenburg, Germany) and is copyrighted.
 *
 * Any unauthorized use of this software without having a valid license
 * violates the license agreement and will be prosecuted by the proper authorities.
 *
 * Creator: dbarlowe
 * Date: 18.05.20 - 21:12
 *
 * @link https://www.dennzo.com
 * @copyright 2020 Dennis Barlowe
 */

namespace Dennzo\WordpressHelper\Model;

class MetaGroupParameters
{
    public const PRIORITY_HIGH = 'high';
    public const PRIORITY_LOW = 'low';

    /**
     * @var string
     */
    private $postTypeSlug, $metaGroupName, $metaGroupDescription, $domain, $position, $priority;

    /**
     * MetaGroupParameters constructor.
     * @param string $metaGroupName Name of the group in which meta fields are placed.
     * @param string $postTypeSlug Slug of the post type, for which the meta box should be registered.
     * @param string $metaGroupDescription Description, which is shown above the meta box.
     * @param string $domain
     * @param string $position
     * @param string $priority
     */
    public function __construct(
        string $metaGroupName,
        string $postTypeSlug,
        string $metaGroupDescription,
        string $domain,
        string $position = 'advanced',
        string $priority = 'default'
    )
    {
        $this->postTypeSlug = $postTypeSlug;
        $this->metaGroupName = $metaGroupName;
        $this->metaGroupDescription = $metaGroupDescription;
        $this->domain = $domain;
        $this->position = $position;
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getPostTypeSlug(): string
    {
        return $this->postTypeSlug;
    }

    /**
     * @return string
     */
    public function getMetaGroupName(): string
    {
        return $this->metaGroupName;
    }

    /**
     * @return string
     */
    public function getMetaGroupDescription(): string
    {
        return $this->metaGroupDescription;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }
}

