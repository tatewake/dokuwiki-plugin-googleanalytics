<?php 
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_googleanalytics extends DokuWiki_Action_Plugin {

	/**
	 * return some info
	 */
	function getInfo(){
		return array(
			'author' => 'Terence J. Grant',
			'email'  => 'tjgrant@tatewake.com',
			'date'   => '2013-02-23',
			'name'   => 'Google Analytics Plugin',
			'desc'   => 'Plugin to embed your google analytics code for your site.',
			'url'    => 'http://tatewake.com/wiki/projects:google_analytics_for_dokuwiki',
		);
	}
	
	/**
	 * Register its handlers with the DokuWiki's event controller
	 */
	function register(&$controller) {
	    $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE',  $this, '_addHeaders');
	}

	function _addHeaders (&$event, $param) {
		global $INFO;
		if(!$this->getConf('GAID')) return;
		if($this->getConf('dont_count_admin') && $INFO['isadmin']) return;
		if($this->getConf('dont_count_users') && $_SERVER['REMOTE_USER']) return;
		$event->data["script"][] = array (
		  "type" => "text/javascript",
		  "_data" => "var _gaq = _gaq || []; _gaq.push(['_setAccount', '".$this->getConf('GAID')."']); _gaq.push(['_trackPageview']);"
		);
		$event->data["script"][] = array (
		  "type" => "text/javascript",
		  "_data" => "(function(){var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();"
		);

	}
}
?>