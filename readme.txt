===============================
Plugin Name:Event-plugin
Developer: sanjay subba
===============================

================================
Description
================================
This is a simple plugin to display the custom post types events for technical assesment.

================================
How to activate
================================
- Just download it and save in folder name event-plugin then upload it in 'wp-content/plugins' folder

================================
How it works
================================
- It installs the 'event' CPT and 'event-type' taxonomy.
- you can add new events and new taxonomy.
- Location custom fiedld has also been added in 'event' CPT.
- To display the event in page you can use shortcode
	>[event] for normal event CPT.
	>[event-filter]	for event CPT with filter.
	>Also both the shortcode contains two parameters 'type' and 'limit'.
	>You can use shortcode as [event type="webinar" limit="4"] where webinar is the event-type's terms.
-Also REST API custom endpoints for event CPT is also provided. you can access it going to the url 'site_url/wp-json/api/v1/events'	