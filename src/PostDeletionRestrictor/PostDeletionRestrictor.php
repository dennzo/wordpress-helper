<?php
/**
 * This software belongs to Dennis Barlowe (Aschaffenburg, Germany) and is copyrighted.
 *
 * Any unauthorized use of this software without having a valid license
 * violates the license agreement and will be prosecuted by the proper authorities.
 *
 * Creator: dbarlowe
 * Date: 15.05.20 - 16:18
 *
 * @link https://www.dennzo.com
 * @copyright 2020 Dennis Barlowe
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
     * @param int[]|array $posts
     */
    public function __construct(array $posts)
    {
        $this->restrictedPosts = array_filter($posts, 'is_int');

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
     * @param int $postId
     * @return bool
     */
    private function register(int $postId): bool
    {
        if (!empty($this->restrictedPosts)) {
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

            // Now redirect back to the current page.
            wp_redirect(admin_url('/edit.php?post_type=' . $postType));

            // Show an alert, so the user knows what he has done wrong.
            echo "<script>alert(\"This page is protected against deletion.\")</script>";

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
