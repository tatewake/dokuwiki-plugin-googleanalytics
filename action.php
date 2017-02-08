<?php
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');

/**
 * Class action_plugin_googleanalytics
 */
class action_plugin_googleanalytics extends DokuWiki_Action_Plugin {

    private $gaEnabled = true;

    /**
     * Register its handlers with the DokuWiki's event controller
     *
     * @param Doku_Event_Handler $controller
     */
    function register(Doku_Event_Handler $controller) {
        $controller->register_hook('DOKUWIKI_STARTED', 'AFTER', $this, 'gaConfig');
    }

    /**
     * Initialize the Google Analytics config
     *
     * @param Doku_Event $event
     * @param array $param
     */
    public function gaConfig(Doku_Event $event, $param) {
        global $JSINFO;
        global $INFO;
        global $ACT;
        global $QUERY;
        global $ID;
        global $INPUT;

        if(!$this->gaEnabled) return;
        $trackingId = $this->getConf('GAID');
        if(!$trackingId) return;
        if($this->getConf('dont_count_admin') && $INFO['isadmin']) return;
        if($this->getConf('dont_count_users') && $_SERVER['REMOTE_USER']) return;

        $options = array();
        if($this->getConf('track_users') && $_SERVER['REMOTE_USER']) {
            $options['userId'] = md5(auth_cookiesalt() . 'googleanalytics' . $_SERVER['REMOTE_USER']);
        }
        if($this->getConf('domainName')) {
            $options['cookieDomain'] = $this->getConf('domainName');
            $options['legacyCookieDomain'] = $this->getConf('domainName');
        }

        // normalize the pageview
        if($ACT == 'search') {
            $view = '~search/?' . rawurlencode($QUERY);
        } elseif($ACT == 'admin') {
            $page = $INPUT->str('page');
            $view = '~admin';
            if($page) $view .= '/' . $page;
        } else {
            $view = str_replace(':', '/', $ID); // slashes needed for Content Drilldown
        }
        $view = DOKU_REL . $view; // prepend basedir, allows logging multiple dir based animals in one tracker

        $JSINFO['ga'] = array(
            'trackingId' => $trackingId,
            'anonymizeIp' => (bool) $this->getConf('anonymize'),
            'action' => act_clean($ACT),
            'trackOutboundLinks' => (bool) $this->getConf('track_links'),
            'options' => $options,
            'pageview' => $view
        );
    }
}
