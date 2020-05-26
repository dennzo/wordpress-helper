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

namespace Dennzo\WordpressHelper\Renamer;

class DefaultPageTemplateRenamer
{
    /**
     * DefaultPageTemplateRenamer constructor.
     * @param string $name The name which the template should be named in the page attributes.
     * @param string $domain
     */
    public function __construct(string $name, string $domain = '')
    {
        add_filter('default_page_template_title', function () use ($name, $domain) {
            return __($name, $domain);
        });
    }
}
