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

        if(!$this->gaEnabled) return;
        $trackingId = $this->getConf('GAID');
        if(!$trackingId) return;
        if($this->getConf('dont_count_admin') && $INFO['isadmin']) return;
        if($this->getConf('dont_count_users') && $_SERVER['REMOTE_USER']) return;
        act_clean($ACT);

        $options = array();
        if($this->getConf('track_users') && $_SERVER['REMOTE_USER']) {
            $options['userId'] = md5(auth_cookiesalt() . 'googleanalytics' . $_SERVER['REMOTE_USER']);
        }
        if($this->getConf('domainName')) {
            $options['cookieDomain'] = $this->getConf('domainName');
            $options['legacyCookieDomain'] = $this->getConf('domainName');
        }

        $JSINFO['ga'] = array(
            'trackingId' => $trackingId,
            'anonymizeIp' => (bool) $this->getConf('anonymize'),
            'action' => $ACT,
            'trackOutboundLinks' => (bool) $this->getConf('track_links'),
            'options' => $options,
            'pageview' => $this->getPageView(),
        );
    }

    /**
     * normalize the pageview
     *
     * @return string
     */
    protected function getPageView() {
        global $QUERY;
        global $ID;
        global $INPUT;
        global $ACT;

        // clean up parameters to log
        $params = $_GET;
        if(isset($params['do'])) unset($params['do']);
        if(isset($params['id'])) unset($params['id']);

        // decide on virtual views
        if($ACT == 'search') {
            $view = '~search/';
            $params['q'] = $QUERY;
        } elseif($ACT == 'admin') {
            $page = $INPUT->str('page');
            $view = '~admin';
            if($page) $view .= '/' . $page;
            if(isset($params['page'])) unset($params['page']);
        } else {
            $view = str_replace(':', '/', $ID); // slashes needed for Content Drilldown
        }

        // prepend basedir, allows logging multiple dir based animals in one tracker
        $view = DOKU_REL . $view;

        // append query parameters
        $query = http_build_query($params, '', '&');
        if($query) $view .= '?' . $query;

        return $view;
    }
}
