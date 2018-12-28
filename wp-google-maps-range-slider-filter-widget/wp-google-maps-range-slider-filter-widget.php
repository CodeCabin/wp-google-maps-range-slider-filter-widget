<?php
/*
Plugin Name: WP Google Maps - Range slider filter widget
Description: This plugin will add a range slider to the available custom field filter widgets
Version: 1.0
*/

namespace MyCustomFilterWidgets;

require_once(plugin_dir_path(__FILE__) . 'wp-google-maps-range-slider-filter.php');

// This is the main class representing the filter widget
class RangeSlider extends \WPGMZA\CustomFieldFilterWidget
{
	public function __construct($filter)
	{
		// Always remember to call the parent constructor
		\WPGMZA\CustomFieldFilterWidget::__construct($filter);
	}
	
	public function html()
	{
		// This function returns the HTML for the filter widget
		$attributes = $this->getAttributesString();
		
		return "<div $attributes></div>";
	}
}

// Add an option in the filter type dropdown on the custom fields page
add_filter('wpgmza_custom_fields_widget_type_options', function($field) {

	$selected = ($field && $field->widget_type == 'range-slider' ? 'selected="selected"' : '');
	
	return '<option value="range-slider" ' . $selected . '>Range Slider</option>';
	
});

// Enqueue the jQuery range slider script
add_action('wp_enqueue_scripts', function() {
	
	$scriptLoader = new \WPGMZA\ScriptLoader(true);
	$scripts = $scriptLoader->getPluginScripts();
	$dependencies = array_keys($scripts);
	
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script(
		'wpgmza-range-slider-filter-widget', 
		plugin_dir_url(__FILE__) . 'wp-google-maps-range-slider-filter-widget.js', 
		$dependencies
	);
	
});

// This filter is called to get a widget to correspond with the specified filter
add_filter('wpgmza_get_custom_field_filter_widget', function($filter) {
	
	if($filter->getFieldData()->widget_type == 'range-slider')
		return new RangeSlider($filter);
	
	return $filter;
	
});