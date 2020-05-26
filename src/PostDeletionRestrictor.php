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

class PostDeletionRestrictor
{
    /**
     * @var int[]|array
     */
    private $restrictedPosts;

    /**
     * PostDeletionRestrictor constructor.
     * @param int[]|array $postIds An array of post ids.
     */
    public function __construct(array $postIds)
    {
        $this->restrictedPosts = array_filter($postIds, 'is_int');

        // Add the action when the user wants to move the post to the trash can.
        add_action(
            'wp_trash_post',
            [$this, 'register'],
            1,
            1
        );

        // Add the action when the user wants to permanently delete the post.
        add_action(
            'before_delete_post',
            [$this, 'register'],
            1,
            1
        );
    }

    /**
     * Do not call this function directly! Needs to be public so that the wordpress hook can access it.
     *
     * @param int $postId
     * @return bool
     */
    public function register(int $postId): bool
    {

        if (empty($this->restrictedPosts)) {
            return false;
        }

        // Don't accept multidimensional arrays.
        if ($this->isArrayMultidimensional($this->restrictedPosts)) {
            error_log('Please provide a valid array of post ids.');

            return false;
        }

        // Filter out everything, which is not a number.
        if (in_array($postId, $this->restrictedPosts)) {
            // Retrieve the post type of the current post.
            $postType = get_post_type($postId);

            // Build the redirect url
            $redirectUrl = admin_url('/edit.php?post_type=' . $postType);

            // Show an alert, so the user knows what he has done wrong.
            // And redirect back to the current page.
            echo "<script>alert('This page is protected against deletion.');window.location.href='$redirectUrl';</script>";

            // Unfortunately wordpress needs an exit here.
            exit();
        }

        return true;
    }

    /**
     * @param array $array
     * @return bool
     */
    private function isArrayMultidimensional(array $array): bool
    {
        if (count($array) === count($array, COUNT_RECURSIVE)) {
            return false;
        }

        return true;
    }
}
