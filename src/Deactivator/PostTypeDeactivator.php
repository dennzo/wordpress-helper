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

namespace Dennzo\WordpressHelper\Deactivator;

class PostTypeDeactivator
{
    public function __construct(string $postTypeToDeactivate)
    {
        add_filter('register_post_type_args', function ($args, $postType) use ($postTypeToDeactivate) {
            if ($postType === $postTypeToDeactivate) {
                $args['public'] = false;
                $args['show_ui'] = false;
                $args['show_in_menu'] = false;
                $args['show_in_admin_bar'] = false;
                $args['show_in_nav_menus'] = false;
                $args['can_export'] = false;
                $args['has_archive'] = false;
                $args['exclude_from_search'] = true;
                $args['publicly_queryable'] = false;
                $args['show_in_rest'] = false;
            }

            return $args;
        }, 0, 2);

    }
}
