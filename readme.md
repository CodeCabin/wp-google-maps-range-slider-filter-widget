# Custom Filtering Widget Example

This repo shows how to use the hooks provided by WP Google Maps to add your own filtering widgets.

Please note the distinction between a "filter" (logic) and a "filtering widget" (UI).

## Define your widget

1. Define a class extending `\WPGMZA\CustomFieldFilterWidget` [see here](https://github.com/CodeCabin/wp-google-maps-range-slider-filter-widget/blob/master/wp-google-maps-range-slider-filter-widget/wp-google-maps-range-slider-filter-widget.php)
2. Add a filter on `wpgmza_get_custom_field_filter_widget`, returning an instance of your widget when the input `$filter` requests it by filter type.
3. Add a filter on `wpgmza_custom_fields_widget_type_options`, returning an `<option>` element. This will allow the user to select your widget from the widget type dropdown.

## Define the filtering logic

1. Define a class extending `\WPGMZA\CustomFieldFilter` [see here](https://github.com/CodeCabin/wp-google-maps-range-slider-filter-widget/blob/master/wp-google-maps-range-slider-filter-widget/wp-google-maps-range-slider-filter.php)
2. Override the `getFilteringSQL` method in this class. It receives the `$value` passed from the user, and should return a statement prepared by `$wpdb->prepare`.
3. Add a filter on `wpgmza_get_custom_field_filter`, returning an instance of this class when the input `$filter` requests it by filter type.