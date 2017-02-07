<?php
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');

/**
 * Class action_plugin_googleanalytics
 */
class action_plugin_googleanalytics extends DokuWiki_Action_Plugin {

    private $mustNotShow = false;

    /**
     * Register its handlers with the DokuWiki's event controller
     *
     * @param Doku_Event_Handler $controller
     */
    function register(Doku_Event_Handler $controller) {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, '_addHeaders');
        $controller->register_hook('POPUPVIEWER_DOKUWIKI_STARTED', 'BEFORE', $this, 'popupviewer_handler');
        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, 'ajax_provider');
    }

    /**
     * Default setup of the needed javascript for tracking
     *
     * @param Doku_Event $event
     * @param array $param
     */
    function _addHeaders(Doku_Event $event, $param) {
        global $INFO;
        if($this->mustNotShow || !$this->getConf('GAID')) return;
        if($this->getConf('dont_count_admin') && $INFO['isadmin']) return;
        if($this->getConf('dont_count_users') && $_SERVER['REMOTE_USER']) return;

        $options = array();
        $options[] = "_gaq.push(['_setAccount', '" . $this->getConf('GAID') . "'])";

        if($this->getConf('anonymize')) {
            $options[] = "_gaq.push(['_gat._anonymizeIp'])";
        }

        $domainName = $this->getConf('domainName');
        if(!empty($domainName)) {
            $options[] = "_gaq.push(['_setDomainName', '" . $domainName . "'])";
        }

        $options[] = "_gaq.push(['_gat._forceSSL'])";
        $options[] = "_gaq.push(['_trackPageview']);";

        $event->data["script"][] = array(
            "type" => "text/javascript",
            "_data" => "var _gaq = _gaq || [];" . implode(';', $options)
        );

        $event->data["script"][] = array(
            "type" => "text/javascript",
            "_data" => "(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();"
        );
    }

    /**
     * Track links in the popuviewer plugin
     *
     * @link https://www.dokuwiki.org/plugin:popupviewer
     * @param Doku_Event $event
     * @param array $param
     */
    function popupviewer_handler(Doku_Event $event, $param) {
        global $ID;

        // Only track self
        $event->data["popupscript"][] = array(
            "type" => "text/popupscript",
            "_data" => "googleanalytics_trackLink(typeof trackLink == 'string'?trackLink:'" . wl($ID) . "');"
        );

        $this->mustNotShow = true;
    }

    /**
     * Handle page tracking when pages are loaded via AJAX
     *
     * @link https://www.dokuwiki.org/plugin:fastwiki
     * @param Doku_Event $event
     * @param array $param
     */
    function ajax_provider(Doku_Event $event, $param) {
        global $ACT;
        $this->mustNotShow = $ACT != 'show';
    }

}
