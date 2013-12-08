<?php
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_googleanalytics extends DokuWiki_Action_Plugin {

    /**
     * return some info
     */
    function getInfo() {
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
        $controller->register_hook('TPL_ACT_RENDER', 'AFTER',  $this, '_addScripts');
    }

    function _addScripts(&$event, $param) {
        global $INFO;
        if(!$this->getConf('GAID')) return;
        if($this->getConf('dont_count_admin') && $INFO['isadmin']) return;
        if($this->getConf('dont_count_users') && $_SERVER['REMOTE_USER']) return;

        echo "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '" . $this->getConf('GAID') . "');
  ga('send', 'pageview');

</script>";

    }
}
?>
