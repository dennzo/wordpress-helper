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
                $args['capabilities'] = [
                    'edit_post' => false,
                    'read_post' => false,
                    'delete_post' => false,
                    'edit_posts' => false,
                    'edit_others_posts' => false,
                    'publish_posts' => false,
                    'read' => false,
                    'delete_posts' => false,
                    'delete_private_posts' => false,
                    'delete_published_posts' => false,
                    'delete_others_posts' => false,
                    'edit_private_posts' => false,
                    'edit_published_posts' => false,
                    'create_posts' => false,
                ];
            }

            return $args;
        }, 0, 2);

    }
}
