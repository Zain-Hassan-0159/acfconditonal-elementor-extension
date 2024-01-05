<?php
namespace ACFCondional\Addons\Elementor\PublicSide;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    die;
}

class acfconditionalElementorPublic{

    public function __construct(){}

    public function filter_section_content_before( $section ) {
        if($section->get_type()==='widget') return false;
        ob_start();
    }

    public function filter_section_content_after( $section ) {
        if($section->get_type()==='widget') return false;
        $content = ob_get_clean();
        $toshow = $this->filter_element_through_condition($content,$section);
        echo $toshow;
    }

    public function filter_element_through_condition($content,$el){
        $is_editor =  \Elementor\Plugin::$instance->editor->is_edit_mode();
        $settings = $el->get_active_settings();
        global $wp_query;
        $post_id = get_the_ID();
        $key_value = get_field($settings['acfconditional_keys'], $post_id);
        $condition = $settings['acfconditional_condtions'];
        $condition_value = $settings['acfconditional_keys_value'];


        if($key_value !== null){
            
            if($condition === 'default'){
                return $content;
            }
            if($condition === 'equal'){
                if($condition_value === $key_value){
                    return;
                }
            }
            if($condition === 'greater'){
                if($condition_value < $key_value){
                    return;
                }
            }
            if($condition === 'less'){
                if($condition_value > $key_value){
                    return;
                }
            }

        }
        return $content;

    }

}
