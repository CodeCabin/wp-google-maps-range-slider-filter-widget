jQuery(function($) {

	window.MyCustomFilterWidgets = {};
	
	// Define the modules constructor
	MyCustomFilterWidgets.RangeSlider = function(element)
	{
		// Call the parent constructor
		WPGMZA.CustomFieldFilterWidget.call(this, element);
		
		// Initialize the jQuery slider
		$(element).slider({
			range: true,
			min: 0,
			max: 1000,
			values: [75, 300],
			change: function(event, ui) {
				$(element).trigger("change");
			}
		});
	}
	
	// Extend from WPGMZA.CustomFieldFilterWidget
	MyCustomFilterWidgets.RangeSlider.prototype = Object.create(WPGMZA.CustomFieldFilterWidget.prototype);
	MyCustomFilterWidgets.RangeSlider.prototype.constructor = MyCustomFilterWidgets.RangeSlider;
	
	// Remember the original createInstance function
	var original = WPGMZA.CustomFieldFilterWidget.createInstance;
	
	// Override the filter widget createInstance function
	WPGMZA.CustomFieldFilterWidget.createInstance = function(element)
	{
		var widgetPHPClass = $(element).attr("data-wpgmza-filter-widget-class");
		
		// Return our module if the module has data-wpgmza-filter-widget-class "MyCustomFilterWidgets\RangeSlider"
		if(widgetPHPClass == 'MyCustomFilterWidgets\\RangeSlider')
			return new MyCustomFilterWidgets.RangeSlider(element);
		
		// Otherwise, fall back to the original createInstance function
		return original(element);
	}
	
	// Get parameters to send with custom field filter AJAX request
	MyCustomFilterWidgets.RangeSlider.prototype.getAjaxRequestData = function()
	{
		var data = WPGMZA.CustomFieldFilterWidget.prototype.getAjaxRequestData.call(this);
		
		data.value = $(this.element).slider("option", "values");
		
		return data;
	}
	
});