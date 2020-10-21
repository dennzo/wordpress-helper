# Wordpress Helper Tools

Readme will follow once released and working. :) 



// Wordpress just won't let you get the menu object, so we need to use this hacky way...
function get_menu_items_by_registered_slug($menu_slug)
{
    $menu_items = array();
    if (($locations = get_nav_menu_locations()) && isset($locations[$menu_slug])) {
        $menu = get_term($locations[$menu_slug]);
        $menu_items = wp_get_nav_menu_items($menu->term_id);
    }

    return $menu_items;
}
