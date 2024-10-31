jQuery(document).ready(function() {
	
	jQuery('.fluent-wl-setting-tabs').on('click', '.fluent-wl-tab', function(e) {
		e.preventDefault();
		var id = jQuery(this).attr('href');
		jQuery(this).siblings().removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.fluent-wl-setting-tabs-content .fluent-wl-setting-tab-content').removeClass('active');
		jQuery('.fluent-wl-setting-tabs-content').find(id).addClass('active');
	});


});
 
