jQuery(document).ready(function($){
	
	jQuery('.kj_simple_button_color_picker').wpColorPicker();
	jQuery('.select_with_auto_option').each(function(index, el){

		if(el.attributes["select-for"].value){
			const t = el.attributes["select-for"].value;
			const v = el.options[el.selectedIndex].value;
			if(v === "auto"){
				jQuery('input[name="kj_simple_button_settings[kj_simple_button_' + t + '_value]"]').prop( "disabled", true );
				jQuery('input[name="kj_simple_button_settings[kj_simple_button_' + t + '_value]"]').val( 0 );
			} else {
				jQuery('input[name="kj_simple_button_settings[kj_simple_button_' + t + '_value]"]').prop( "disabled", false );
			}
		}
	});
	jQuery('.checkbox-change-hover').each(function(index, el){
		if(el.checked){
			jQuery(this).closest(".hover_group_parent").find("input[type='number']").prop("disabled", false);
			jQuery(this).closest(".hover_group_parent").find("button").prop("disabled", false);
			jQuery(this).closest(".hover_group_parent").find("select").prop("disabled", false);
			
		} else{
			jQuery(this).closest(".hover_group_parent").find("input[type='number']").prop("disabled", true);
			jQuery(this).closest(".hover_group_parent").find("button").prop("disabled", true);
			jQuery(this).closest(".hover_group_parent").find("select").prop("disabled", true);
		}		
	});
	
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
				jQuery('input[name="kj_simple_button_settings[kj_simple_button_' + item + '_value]"]').val(mainValue).trigger('change');
				jQuery('select[name="kj_simple_button_settings[kj_simple_button_' + item + '_unit]"]').val(mainUnit).trigger('change');
			});
			
		};
	});
	
	jQuery('input[name="kj_simple_button_settings[kj_simple_button_advanced_mode]').change(function(e){
		if(e.target.checked){
			jQuery('tr.advanced-option').fadeIn();
		} else{
			jQuery('tr.advanced-option').fadeOut();
		}
	});
	
	jQuery('.select_with_auto_option').change(function(e){
		if(e.target.attributes["select-for"].value){
			const t = e.target.attributes["select-for"].value;
			const v = e.target.options[e.target.selectedIndex].value;
			if(v === "auto"){
				jQuery('input[name="kj_simple_button_settings[kj_simple_button_' + t + '_value]"]').prop( "disabled", true );
				jQuery('input[name="kj_simple_button_settings[kj_simple_button_' + t + '_value]"]').val( 0 );
			} else {
				jQuery('input[name="kj_simple_button_settings[kj_simple_button_' + t + '_value]"]').prop( "disabled", false );
			}
		}
	});
	jQuery(".checkbox-change-hover").change(function(e){
		if(jQuery(this).prop("checked")){
			jQuery(this).closest(".hover_group_parent").find("input[type='number']").prop("disabled", false);
			jQuery(this).closest(".hover_group_parent").find("button").prop("disabled", false);
			jQuery(this).closest(".hover_group_parent").find("select").prop("disabled", false);
			
		} else{
			jQuery(this).closest(".hover_group_parent").find("input[type='number']").prop("disabled", true);
			jQuery(this).closest(".hover_group_parent").find("button").prop("disabled", true);
			jQuery(this).closest(".hover_group_parent").find("select").prop("disabled", true);
		}		
	});
});
