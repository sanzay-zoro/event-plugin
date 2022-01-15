jQuery(document).ready(function(){
  jQuery(".event-filter input").change(function(){
  	const checked = $('input[name="eventType"]:checked');
    var selected = Array.from(checked).map(x => x.value);
    console.log(selected);
	jQuery.ajax({
		url: event_ajax_object.ajax_url,
		type: 'POST',
		dataType: 'html',
		data: {
			'action':'filter_events',
			'terms':selected
			},
		success: function(res) {
	      $('.filtered-content').html(res);
	    }	  
	});
  });
});