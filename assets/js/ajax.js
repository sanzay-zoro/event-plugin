jQuery(document).ready(function(){
  jQuery(".event-filter input").change(function(){
  	const typeChecked = $('input[name="eventType"]:checked');
    var eventTypes = Array.from(typeChecked).map(x => x.value);
  	const tagChecked = $('input[name="eventTag"]:checked');
    var eventTags = Array.from(tagChecked).map(x => x.value); 
    console.log(eventTypes);
    console.log(eventTags);
	jQuery.ajax({
		url: event_ajax_object.ajax_url,
		type: 'POST',
		dataType: 'html',
		data: {
			'action':'filter_events',
			'terms':eventTypes,
			'tags':eventTags
			},
		success: function(res) {
	      $('.filtered-content').html(res);
	    }	  
	});
  });
});