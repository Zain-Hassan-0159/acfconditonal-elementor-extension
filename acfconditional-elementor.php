<?php
/*
Plugin Name: ACF-Conditional Elementor Extension
Description: Conditional integration between ACF and Elementor
Version: 1.2
Author: Zain Hassan
Author URI: http://www.hassanzain.com/
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

@author: Zain Hassan
*/

if(!defined('ABSPATH')){
    die();
}


define('ACFCondional_ELEMENTOR_DIR',__DIR__);
define('ACFCondional_ELEMENTOR_PLUGIN_FILE', ACFCondional_ELEMENTOR_DIR . '/acfconditional-elementor.php');
define('ACFCondional_ELEMENTOR_VERSION','1.1');

add_action( 'plugins_loaded', function(){
    require_once(__DIR__ . '/acfconditional-elementor.class.php');
    $init = ACFCondional\Addons\Elementor\ElementorExtension::get_instance();
    return;
} );

add_action('wp_footer', function(){
	?>
<script>
	document.querySelectorAll('.elementor-widget-container').forEach(function(element) {
  if (element.innerHTML.trim() === '') {
    element.remove();
  }
});

</script>
<?php
});



