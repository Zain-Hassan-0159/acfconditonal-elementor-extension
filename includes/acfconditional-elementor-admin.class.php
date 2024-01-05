<?php
namespace ACFCondional\Addons\Elementor\Admin;
use Elementor\Controls_Manager;


// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    die;
}

class acfconditionalElementorAdmin{
    private $ui_model;
    private $removed_conditions = ['AB-Testing'];


    public function add_acfconditional_standalone_condition_ui($element, $section_id = null, $args = null){
        $ui_model = [];
        $condition_types = [''=>"Select a Key"];
        $options = array();

        $field_groups = acf_get_field_groups();
        foreach ( $field_groups as $group ) {
          // DO NOT USE here: $fields = acf_get_fields($group['key']);
          // because it causes repeater field bugs and returns "trashed" fields
          $fields = get_posts(array(
            'posts_per_page'   => -1,
            'post_type'        => 'acf-field',
            'orderby'          => 'menu_order',
            'order'            => 'ASC',
            'suppress_filters' => true, // DO NOT allow WPML to modify the query
            'post_parent'      => $group['ID'],
            'post_status'      => 'any',
            'update_post_meta_cache' => false
          ));
          foreach ( $fields as $field ) {
            $condition_types[$field->post_name] = $field->post_title;
          }
        }
        $has_valid_license = true;

        $element->start_controls_section(
            'acfconditional_standalone_condition_section',
            [
                'tab' => Controls_Manager::TAB_ADVANCED,
                'label' => 'ACF Conditional Display',
            ]
        );

        $element->add_control(
            'acfconditional_keys',
            [
                'label'=>'Select ACF KEY',
                'label_block'=>'true',
                'type'=>Controls_Manager::SELECT2,
                'options'=>$condition_types,
            ]
        );

        $element->add_control(
			'acfconditional_condtions',
			[
				'label' => 'Select the Conditon',
                'label_block'=>'true',
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => 'Default',
					'equal'  => 'Hide If value is equal to',
					'greater'  => 'Hide If value is greater than ',
					'less'  => 'Hide If value is less than',
				]
			]
		);

        $element->add_control(
			'acfconditional_keys_value',
			[
				'label' => 'Value',
                'label_block'=>'true',
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 5,
				'default' => '',
				'placeholder' => '',
			]
		);


        $element->end_controls_section();
    }

}


?>
