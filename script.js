/**
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Gerry Weißbach <gweissbach@inetsoftware.de>
 */

var googleanalytics_trackLink = function(link, prefix) {

	if ( typeof _gaq != 'undefined' )
	{
    	_gaq.push(['_trackPageview', (typeof prefix != 'undefined' ? prefix : '') + link]);
	}
};

var googleanalytics_trackEvent = function(category, action, label) {

	if ( typeof _gaq != 'undefined' )
	{
    	_gaq.push(['_trackEvent', category, action, label]);
	}
};

var googleanalytics_registerTracking = function() {
    
		if ( typeof _gaq == 'undefined' ) { return; }
    	_gaq.push(['_setAllowLinker', true]);
		
		var expression = new RegExp("^([^\?]*)\?[^=]*$");
		jQuery('a.media:not([tracking]), a.mediafile:not([tracking]), a.interwiki:not([tracking]), a.urlextern:not([tracking])').each(function(){
			
			
			jQuery(this).click(function(e){
				
				googleanalytics_trackLink(this.href.replace(expression, "$1"), '/outgoing?url='); // but track full URL to be sure
				return true;
			}).attr('tracking');
		});

};

(function($){
	$(googleanalytics_registerTracking);
})(jQuery);
