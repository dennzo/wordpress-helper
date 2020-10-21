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

namespace Dennzo\WordpressHelper;

/**
 * TODO: TRANSLATIONS
 * Class PostDateProvider
 * @package Dennzo\WordpressHelper
 */
class PostDateProvider
{
    private const DEFAULT_FORMAT = 'd. M. Y';

    /**
     * @param int $id
     * @param string|null $format
     * @return string
     */
    public static function provideCreationDate(int $id, string $format = null): string
    {
        if (null === $format) {
            $format = static::DEFAULT_FORMAT;
        }

        return 'Created on ' . get_the_date($format, $id);
    }

    /**
     * @param int $id
     * @param string|null $format
     * @return string|null
     */
    public static function provideUpdatedDate(int $id, string $format = null): ?string
    {
        if (null === $format) {
            $format = static::DEFAULT_FORMAT;
        }

        if (get_the_modified_date($format, $id)) {
            return 'Last Update on the ' . get_the_modified_date($format, $id);
        }

        return null;
    }
}
