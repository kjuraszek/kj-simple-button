jQuery(document).ready(function($){
	
	function render_icon(){
		if (jQuery('select[name="kj_simple_button_settings[kj_simple_button_content_type]"]').val() === 'icon'){
			let selected_icon = jQuery('input[name="kj_simple_button_settings[kj_simple_button_content_value]"]').val();
			jQuery('#content-selected-icon-container').fadeIn();
			if(/^dashicons\-[a-z0-9\-]*$/.test(selected_icon)) {
				jQuery('#content-selected-icon').attr('class', 'dashicons ' + selected_icon);
			} else {
				jQuery('#content-selected-icon').removeClass();
			}	
		} else {
			jQuery('#content-selected-icon-container').fadeOut();
			jQuery('#content-selected-icon').removeClass();
		}
	}
	
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
	
	render_icon();
	
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
	
	jQuery('select[name="kj_simple_button_settings[kj_simple_button_content_type]"]').on('change', render_icon);
	
	jQuery('input[name="kj_simple_button_settings[kj_simple_button_content_value]"]').on('change keyup', render_icon);
	
	jQuery('input[name="kj_simple_button_settings[kj_simple_button_advanced_mode]"]').change(function(e){
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
	jQuery('.load-template-btn').click(function(){
		let selected_template = jQuery('select[name="kj_simple_button_settings[kj_simple_button_template]"]').val();
		let template_settings = {};
		switch(selected_template){
			case 'facebook':
				template_settings = {

					"kj_simple_button_height_value" : 48, 
					"kj_simple_button_height_unit" : "px", 
					"kj_simple_button_width_value" : 48, 
					"kj_simple_button_width_unit" : "px",
					"kj_simple_button_horizontal_position" : "right", 
					"kj_simple_button_horizontal_position_value" : 0,  
					"kj_simple_button_horizontal_position_unit" : "px",
					"kj_simple_button_vertical_position" : "bottom", 
					"kj_simple_button_vertical_position_value" : 50,  
					"kj_simple_button_vertical_position_unit" : "%",
					"kj_simple_button_text_align_value" : "center", 
					"kj_simple_button_font_size_value" : 40, 
					"kj_simple_button_font_size_unit" : "px",
					"kj_simple_button_font_color" : "#ffffff",
					"kj_simple_button_background_color" : "#4267b2",
					"kj_simple_button_line_height_value" : 48, 
					"kj_simple_button_line_height_unit" : "px",
					"kj_simple_button_opacity_value" : 1,
					
					"kj_simple_button_padding_top_value" : 0,
					"kj_simple_button_padding_top_unit" : "px",
					"kj_simple_button_padding_right_value" : 0,
					"kj_simple_button_padding_right_unit" : "px",
					"kj_simple_button_padding_bottom_value" : 0,
					"kj_simple_button_padding_bottom_unit" : "px",
					"kj_simple_button_padding_left_value" : 0,
					"kj_simple_button_padding_left_unit" : "px",
					
					"kj_simple_button_margin_top_value" : 0,
					"kj_simple_button_margin_top_unit" : "px",
					"kj_simple_button_margin_right_value" : 0,
					"kj_simple_button_margin_right_unit" : "px",
					"kj_simple_button_margin_bottom_value" : 0,
					"kj_simple_button_margin_bottom_unit" : "px",
					"kj_simple_button_margin_left_value" : 0,
					"kj_simple_button_margin_left_unit" : "px",
					
					"kj_simple_button_border_value" : 0,
					
					"kj_simple_button_border_radius_top_left_value" : 15,
					"kj_simple_button_border_radius_top_left_unit" : "px",
					"kj_simple_button_border_radius_top_right_value" : 0,
					"kj_simple_button_border_radius_top_right_unit" : "px",
					"kj_simple_button_border_radius_bottom_right_value" : 0,
					"kj_simple_button_border_radius_bottom_right_unit" : "px",
					"kj_simple_button_border_radius_bottom_left_value" : 15,
					"kj_simple_button_border_radius_bottom_left_unit" : "px",

					"kj_simple_button_hover_opacity_change" : 1,
					"kj_simple_button_hover_opacity_value" : 0.8,
					
					"kj_simple_button_href_value" : "https://facebook.com/", 
					"kj_simple_button_rel_value" : "", 
					"kj_simple_button_target_value" : "_blank", 
					"kj_simple_button_content_type" : "icon",
					"kj_simple_button_content_value" : "dashicons-facebook-alt",

				}

				break;
			default:	
				template_settings = {
					"kj_simple_button_btn_active" : 1, 
					"kj_simple_button_advanced_mode" : 0, 
					"kj_simple_button_template" : "default", 
					"kj_simple_button_height_value" : 100, 
					"kj_simple_button_height_unit" : "px", 
					"kj_simple_button_width_value" : 100, 
					"kj_simple_button_width_unit" : "px",
					"kj_simple_button_horizontal_position" : "left", 
					"kj_simple_button_horizontal_position_value" : 0,  
					"kj_simple_button_horizontal_position_unit" : "px",
					"kj_simple_button_vertical_position" : "bottom", 
					"kj_simple_button_vertical_position_value" : 0,  
					"kj_simple_button_vertical_position_unit" : "px",
					"kj_simple_button_text_align_value" : "center", 
					"kj_simple_button_font_size_value" : 12, 
					"kj_simple_button_font_size_unit" : "px",
					"kj_simple_button_font_weight_value" : 400, 
					"kj_simple_button_font_family_main" : "Arial Black",
					"kj_simple_button_font_family_fallback" : "sans-serif",
					"kj_simple_button_font_color" : "#ffffff",
					"kj_simple_button_background_color" : "#2d2d2d",
					"kj_simple_button_line_height_value" : 16, 
					"kj_simple_button_line_height_unit" : "px",
					"kj_simple_button_opacity_value" : 1,
					
					"kj_simple_button_padding_top_value" : 5,
					"kj_simple_button_padding_top_unit" : "px",
					"kj_simple_button_padding_right_value" : 5,
					"kj_simple_button_padding_right_unit" : "px",
					"kj_simple_button_padding_bottom_value" : 5,
					"kj_simple_button_padding_bottom_unit" : "px",
					"kj_simple_button_padding_left_value" : 5,
					"kj_simple_button_padding_left_unit" : "px",
					
					"kj_simple_button_margin_top_value" : 5,
					"kj_simple_button_margin_top_unit" : "px",
					"kj_simple_button_margin_right_value" : 5,
					"kj_simple_button_margin_right_unit" : "px",
					"kj_simple_button_margin_bottom_value" : 5,
					"kj_simple_button_margin_bottom_unit" : "px",
					"kj_simple_button_margin_left_value" : 5,
					"kj_simple_button_margin_left_unit" : "px",
					
					"kj_simple_button_border_value" : 0,
					"kj_simple_button_border_unit" : "px",
					"kj_simple_button_border_style" : "solid",
					"kj_simple_button_border_color" : "#d8e2ff",
					
					"kj_simple_button_border_radius_top_left_value" : 0,
					"kj_simple_button_border_radius_top_left_unit" : "px",
					"kj_simple_button_border_radius_top_right_value" : 0,
					"kj_simple_button_border_radius_top_right_unit" : "px",
					"kj_simple_button_border_radius_bottom_right_value" : 0,
					"kj_simple_button_border_radius_bottom_right_unit" : "px",
					"kj_simple_button_border_radius_bottom_left_value" : 0,
					"kj_simple_button_border_radius_bottom_left_unit" : "px",
					
					"kj_simple_button_resolution_max_575" : 1,
					"kj_simple_button_resolution_min_576" : 1,
					"kj_simple_button_resolution_min_768" : 1,
					"kj_simple_button_resolution_min_992" : 1,
					"kj_simple_button_resolution_min_1200" : 1,
					
					"kj_simple_button_transition_duration" : 0,
					"kj_simple_button_transition_timing_function" : "linear",
					"kj_simple_button_transition_delay" : 0,
					
					"kj_simple_button_hover_font_color_change" : 0,
					"kj_simple_button_hover_font_color" : "#ffffff",
					"kj_simple_button_hover_background_color_change" : 0,
					"kj_simple_button_hover_background_color" : "#2d2d2d",
					"kj_simple_button_hover_opacity_change" : 0,
					"kj_simple_button_hover_opacity_value" : 1,
					"kj_simple_button_hover_border_change" : 0,
					"kj_simple_button_hover_border_value" : 0,
					"kj_simple_button_hover_border_unit" : "px",
					"kj_simple_button_hover_border_style" : "solid",
					"kj_simple_button_hover_border_color" : "#d8e2ff",
					
					"kj_simple_button_href_value" : "#", 
					"kj_simple_button_rel_value" : "", 
					"kj_simple_button_target_value" : "", 
					"kj_simple_button_content_type" : "text",
					"kj_simple_button_content_value" : "KJ Simple Button",
					"kj_simple_button_title_value" : "",
					"kj_simple_button_disabled_posts" : "",
					
					"kj_simple_button_enqueue" : "external",
					"kj_simple_button_hook" : "wp_footer"
				}	
			}
			for (let key in template_settings) {
				if (template_settings.hasOwnProperty(key)) {
					if(jQuery('select[name="kj_simple_button_settings['+key+']"]').length === 1){
						jQuery('select[name="kj_simple_button_settings['+key+']"]').val(template_settings[key]).trigger('change');
					} else if(jQuery('input[name="kj_simple_button_settings['+key+']"]').length === 1){
						jQuery('input[name="kj_simple_button_settings['+key+']"]').val(template_settings[key]).trigger('change');
						if(jQuery('input[name="kj_simple_button_settings['+key+']"]').attr('type') === 'checkbox'){
							if(template_settings[key] === 1){
								jQuery('input[name="kj_simple_button_settings['+key+']"]').attr('checked', true);
							} else {
								jQuery('input[name="kj_simple_button_settings['+key+']"]').attr('checked', false);
							}
						}
					}
				}
			}
			
		})
});
