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

use WP_Post;

/**
 * TODO: TRANSLATIONS
 * 
 * Class ReadingTimeCalculator
 * @package Dennzo\WordpressHelper
 */
class ReadingTimeCalculator
{
    /**
     * @param WP_Post $post
     * @param bool $long
     * @return string
     */
    public static function getReadingTime(WP_Post $post, $long = false): string
    {
        $minutes = max(static::calculateRoughEstimate($post), 1);

        if ($long === true) {
            $result = sprintf(
                _n('%d minute reading time', '%d minutes reading time', $minutes, 'dennzo'),
                number_format_i18n($minutes)
            );
        } else {
            $result = sprintf(
                _n('%d min', '%d mins', $minutes, 'dennzo'),
                number_format_i18n($minutes)
            );
        }

        return ($minutes <= 1) ? '<span class="less-than">< </span>' . $result : $result;
    }

    /**
     * @param WP_Post $post
     * @return int
     */
    private static function calculateRoughEstimate(WP_Post $post): int
    {
        $content = $post->post_content;
        $word = str_word_count(strip_tags($content));
        return floor($word / 200);
    }
}
