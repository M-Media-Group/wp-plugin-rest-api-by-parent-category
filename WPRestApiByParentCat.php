<?php
/*
Plugin Name: Get by taxonomy/category parent for WP REST API
Description: Add the ability to get posts by the parent category in the WordPress REST API.
Author: M Media
Version: 1.0.0
Author URI: https://profiles.wordpress.org/Mmediagroup/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

{Plugin Name} is distributed in the hope that it will be useful to Cartes.io clients,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
 */

defined('ABSPATH') or die('No script kiddies please!');

// Add parent_category filter to REST API
if (!function_exists('wprabpc_wp_rest_api_by_parent_category')) {
    function wprabpc_wp_rest_api_by_parent_category($args, $request)
    {
        if (isset($request['parent_category'])) {
            $parent_category = sanitize_text_field($request['parent_category']);
            $args['tax_query'] = [
                [
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'include_children' => true,
                    'operator' => 'IN',
                    'terms' => $parent_category,
                ],
            ];
        }
        return $args;
    }
    add_filter('rest_post_query', 'wprabpc_wp_rest_api_by_parent_category', 10, 3);
}
