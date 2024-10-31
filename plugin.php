<?php

/*
  Plugin Name: Pinterest for Galleries
  Plugin URI: http://www.satollo.net/plugins/pinterest-for-galleries
  Description: Add the Pin-it button of Pinterest under every thumbnail of WordPress galleries
  Version: 1.1.2
  Author: Stefano Lissa
  Author URI: http://www.satollo.net

*/

/*
  Copyright 2012 Stefano Lissa (stefano@satollo.net)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

add_action('admin_head', 'p4g_admin_head');
function p4g_admin_head()
{
    if (strpos($_GET['page'], basename(dirname(__FILE__)) . '/') === 0) {
        echo '<link type="text/css" rel="stylesheet" href="' . plugins_url('admin.css', __FILE__) . '">';
    }
}

add_action('admin_menu', 'p4g_admin_menu');
function p4g_admin_menu() {
    add_options_page('Pinterest for Galleries', 'Pinterest for Galleries', 'manage_options', 'pinterest-for-galleries/options.php');
}


add_filter('attachment_link', 'p4g_attachment_link', 10, 2);
function p4g_attachment_link($link, $id) {
  $mimetypes = array('image/jpeg', 'image/png', 'image/gif');
  $post = get_post($id);
  if (in_array($post->post_mime_type, $mimetypes))
    return wp_get_attachment_url($id);
  return $link;
}

add_action('wp_footer', 'p4g_wp_footer');
function p4g_wp_footer() {
  if (!is_singular())
    return;

  echo '
<script type="text/javascript">
var p4g_dt = document.getElementsByTagName("dt");
for(i=0; i<p4g_dt.length; i++)
{
  var p4g_a = p4g_dt[i].getElementsByTagName("a");
  p4g_dt[i].innerHTML += \'<div style="margin-top: 10px"><a href="http://pinterest.com/pin/create/button/?url=\' + location . href + \'&media=\' + p4g_a[0].href + \'" class="pin-it-button" count-layout="none">Pin It</a></div>\';
}

var script = document.createElement("script");
script.src = "http://assets.pinterest.com/js/pinit.js";
var headID = document.getElementsByTagName("head")[0];         
headID.appendChild(script);
</script>      
';
}
