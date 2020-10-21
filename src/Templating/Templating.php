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

namespace Dennzo\WordpressHelper\Templating;
// TODO: clean, improve and split this class.

/**
 * Class TemplateLoader
 */
class TemplateLoader
{
    private static $templateDirectory = '/template/shortcode/';
    private static $templateDirectoryPath;

    /**
     * TemplateLoader constructor.
     * @param bool $useFromParentTheme If you would like to only use the templates from the parent theme.
     * @param string $templateDirectory Ability to override the template directory.
     */
    public function __construct(bool $useFromParentTheme = false, string $templateDirectory = null)
    {
        // Override the local template directory within the theme
        if (!empty($templateDirectory)) {
            static::$templateDirectory = $templateDirectory;
        }

        // Either use the Templates from the child or base theme
        static::$templateDirectoryPath = (true === $useFromParentTheme) ? get_template_directory() : get_theme_file_path();
        static::$templateDirectoryPath .= static::$templateDirectory;

        // Adding a wordpess filter for creating a shortcode list and retrieving the HTML output
        add_filter("template_shortcodes", function () {
            return TemplateLoader::getShortCodeList();
        });

        // Now actually register the shortcodes
        add_action("init", function () {
            $shortCodes = apply_filters("template_shortcodes", array());
            if (empty($shortCodes)) {
                return;
            }

            foreach (array_keys($shortCodes) as $shortCodeSlug) {
                add_shortcode($shortCodeSlug, [$this, 'shortCodeCallback']);
            }
        });
    }


    /**
     * Like get_template_part() put lets you pass args to the template file
     * Args are available in the template as $template_args array
     * This method is always based in the root of the theme directory - get_template_directory().
     *
     * @param string filepart
     * @param array $template_args
     * @param array $cache_args
     * @return bool|false|mixed|string|void
     */
    public static function get_template_part_with_params($file, $template_args = array(), $cache_args = array())
    {
        // Parse Template and caching arguments
        $template_args = wp_parse_args($template_args);
        $cache_args = wp_parse_args($cache_args);

        // Do cache stuff
        if ($cache_args) {
            foreach ($template_args as $key => $value) {
                if (is_scalar($value) || is_array($value)) {
                    $cache_args[$key] = $value;
                } else if (is_object($value) && method_exists($value, 'get_id')) {
                    $cache_args[$key] = call_user_func('get_id', $value);
                }
            }
            if (($cache = wp_cache_get($file, serialize($cache_args))) !== false) {
                if (!empty($template_args['return'])) {
                    return $cache;
                }
                echo $cache;
                return;
            }
        }

        $file_handle = $file;
        do_action('start_operation', 'template_part_with_params::' . $file_handle);
        if (file_exists(get_stylesheet_directory() . '/' . $file . '.php')) {
            $file = get_stylesheet_directory() . '/' . $file . '.php';
        } elseif (file_exists(get_template_directory() . '/' . $file . '.php')) {
            $file = get_template_directory() . '/' . $file . '.php';
        }
        ob_start();
        $return = require($file);
        $data = ob_get_clean();
        do_action('end_operation', 'template_part_with_params::' . $file_handle);
        if ($cache_args) {
            wp_cache_set($file, $data, serialize($cache_args), 3600);
        }

        // If the input should be returned as a string
        if (!empty($template_args['return'])) {
            return (false !== $return) ? $data : false;
        }

        echo $data;
    }


    /**
     * @param array $atts
     * @param string $content
     * @param string $tag
     * @return string
     */
    public static function shortCodeCallback($atts, $content = '', $tag): string
    {
        $shortCodeList = apply_filters("template_shortcodes", []);

        return $shortCodeList[$tag]['html'];
    }

    /**
     * @return array|null
     */
    public static function getShortCodeList()
    {
        // Check if the base directory exists either in the main or in the child
        if (!is_dir(static::$templateDirectoryPath)) {
            return null;
        }

        // Get the root content of the directory
        $directories = scandir(static::$templateDirectoryPath);

        // Filter out everything which is not a directory.
        $directories = static::filterEverythingButDirectories($directories);

        if (empty($directories)) {
            return null;
        }

        // Get all files in the needed format
        $files = static::getCleanedFileList($directories);

        $shortCodeList = static::buildShortCodeList($files);

        return (!empty($shortCodeList)) ? $shortCodeList : null;
    }

    /**
     * @param array $directories
     * @return array
     */
    private static function filterEverythingButDirectories(array $directories): array
    {
        return array_filter($directories, function (string $directory) {
            if (in_array($directory, ['.', '..']) || !empty(pathinfo($directory, PATHINFO_EXTENSION))) {
                return false;
            }

            return true;
        });
    }

    /**
     * @param array $directories
     * @return array|null
     */
    private static function getCleanedFileList(array $directories): ?array
    {
        foreach ($directories as $directory) {
            $directoryContent = scandir(static::$templateDirectoryPath . $directory);

            $fileList = static::filterEverythingButFiles($directoryContent);

            if (!empty($fileList)) {
                $files[$directory] = array_values($fileList);
            }

        }

        return !empty($files) ? $files : null;
    }

    /**
     * @param array $directories
     * @param array $allowedFileExtensions
     * @return array
     */
    private static function filterEverythingButFiles(array $directories, array $allowedFileExtensions = ['php']): array
    {
        return array_filter($directories, function (string $directory) use ($allowedFileExtensions) {

            $extension = pathinfo($directory, PATHINFO_EXTENSION);

            if (in_array($directory, ['.', '..']) || empty($extension) || !in_array($extension, $allowedFileExtensions)) {
                return false;
            }

            return true;
        });
    }


    /**
     * @param array $fileTree
     * @return array|null
     */
    private static function buildShortCodeList(array $fileTree): ?array
    {
        // This iterates each directory
        foreach ($fileTree as $directoryName => $files) {

            // Now iterate each file within the directoy
            foreach ($files as $file) {
                $path = $directoryName . '/' . $file;
                $fileName = pathinfo(static::$templateDirectory . $path, PATHINFO_FILENAME);

                // Build the shortcode list
                $shortCodeName = "display-$directoryName-$fileName";
                $shortCodeList[$shortCodeName] = [
                    'html' => static::getTemplatePart($directoryName, $fileName)
                ];
            }

        }

        return !empty($shortCodeList) ? $shortCodeList : null;
    }


    /**
     * @param string $directoryName
     * @param string $fileName
     * @return string
     */
    private static function getTemplatePart(string $directoryName, string $fileName): string
    {
        ob_start();
        get_template_part(static::$templateDirectory . "$directoryName/$fileName");
        $content = ob_get_contents();
        ob_get_clean();

        return (false !== $content) ? $content : '';
    }

}
