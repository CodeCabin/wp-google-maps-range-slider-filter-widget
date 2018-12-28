<?php

namespace MyCustomFilter;

// Define the class, extending from \WPGMZA\CustomFieldFilter
class RangeFilter extends \WPGMZA\CustomFieldFilter
{
	// Define the classes constructor
	public function __construct($field_id, $map_id)
	{
		// Call the parent constructor
		\WPGMZA\CustomFieldFilter::__construct($field_id, $map_id);
	}
	
	// Return the SQL for filtering logic. The SQL should 
	public function getFilteringSQL($value)
	{
		global $wpdb;
		global $WPGMZA_TABLE_NAME_MARKERS_HAS_CUSTOM_FIELDS;
		
		$qstr = "SELECT object_id AS id 
			FROM $WPGMZA_TABLE_NAME_MARKERS_HAS_CUSTOM_FIELDS
			WHERE value BETWEEN %d AND %d
			AND field_id = %d";
		
		$params = array(
			$value[0], 
			$value[1], 
			$this->getFieldID()
		);
		
		$stmt = $wpdb->prepare($qstr, $params);
		
		return $stmt;
	}
}

// Add a filter for wpgmza_get_custom_field_filterwpgmza_get_custom_field_filter
add_filter('wpgmza_get_custom_field_filter', function($field_id, $map_id) {
	
	if(\WPGMZA\CustomFieldFilter::getWidgetType($field_id) == 'range-slider')
		return new RangeFilter($field_id, $map_id);
	
	return $field_id;
	
}, 10, 2);