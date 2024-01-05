<?php
namespace ACFCondional\Addons\Elementor;
use ACFCondional\Addons\Elementor\Admin\acfconditionalElementorAdmin;
use ACFCondional\Addons\Elementor\PublicSide\acfconditionalElementorPublic;

require_once(__DIR__ . '/includes/acfconditional-elementor-admin.class.php');
require_once(__DIR__ . '/includes/acfconditional-elementor-public.class.php');

class ElementorExtension{
    private static $instance;

    private function __construct(){
        add_action( 'elementor/init', [ $this, 'init' ] );
    }

    public static function get_instance() {
        if ( NULL == self::$instance )
            self::$instance = new ElementorExtension();

        return self::$instance;
    }

    public function init(){
        $this->register_admin_hooks();
        $this->register_public_hooks();

    }

    public function register_admin_hooks(){
        $admin = new acfconditionalElementorAdmin();
        add_action( 'elementor/element/column/section_advanced/after_section_end', [$admin,'add_acfconditional_standalone_condition_ui'], 10, 3 );
        add_action( 'elementor/element/section/section_advanced/after_section_end', [$admin,'add_acfconditional_standalone_condition_ui'], 10, 3 );
        add_action( 'elementor/element/common/_section_style/after_section_end', [$admin,'add_acfconditional_standalone_condition_ui'], 10, 3 );

        add_action( 'elementor/element/popup/section_advanced/after_section_end', [$admin,'add_acfconditional_standalone_condition_ui'], 10, 3 );

    }

    public function register_public_hooks(){
        $public = new acfconditionalElementorPublic();

        add_action( "elementor/frontend/section/before_render", [$public, 'filter_section_content_before'], 10, 1 );
        add_action( "elementor/frontend/section/after_render", [$public, 'filter_section_content_after'], 10, 1 );
        add_action( "elementor/frontend/column/before_render", [$public, 'filter_section_content_before'], 10, 1 );
        add_action( "elementor/frontend/column/after_render", [$public, 'filter_section_content_after'], 10, 1 );

        add_filter('elementor/widget/render_content',[$public, 'filter_element_through_condition'],10,2);
    }

}