jQuery(document).ready(function($){
	
	jQuery('.button-set-for-all').click(function(e){
		if(e.target.attributes["button-for"].value){
			const t = e.target.attributes["button-for"].value;
			let mainElement, otherElements, mainUnit, mainValue;
			if(t === "border-radius"){
				mainElement = "border_radius_top_left";
				otherElements = ["border_radius_top_right", "border_radius_bottom_right", "border_radius_bottom_left"];
			} else {
				mainElement = t + "_top";
				otherElements = [t + "_right", t + "_bottom", t + "_left"];
			}
			mainValue = jQuery('input[name="kj_simple_button_settings[kj_simple_button_' + mainElement + '_value]"]').val();
			mainUnit = jQuery('select[name="kj_simple_button_settings[kj_simple_button_' + mainElement + '_unit]"] option:selected').val();
			
			otherElements.forEach(function(item){
				jQuery('input[name="kj_simple_button_settings[kj_simple_button_' + item + '_value]"]').val(mainValue);
				jQuery('select[name="kj_simple_button_settings[kj_simple_button_' + item + '_unit]"]').val(mainUnit);
			});
			console.log(mainUnit);
			
		};
	});
	
	jQuery('input[name="kj_simple_button_settings[kj_simple_button_advanced_mode]').change(function(e){
		if(e.target.checked){
			jQuery('tr.advanced-option').fadeIn();
		} else{
			jQuery('tr.advanced-option').fadeOut();
		}
	});
	
});
