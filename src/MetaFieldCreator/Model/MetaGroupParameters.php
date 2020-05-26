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

