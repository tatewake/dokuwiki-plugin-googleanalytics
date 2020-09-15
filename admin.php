<?php

/**
 * Google Analytics for DokuWiki
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Terence J. Grant<tjgrant@tatewake.com>
 */

class admin_plugin_googleanalytics extends DokuWiki_Admin_Plugin
{
    /** @inheritdoc */
    public function handle()
    {
        global $INPUT;
        if ($INPUT->post->has('pref') && checkSecurityToken()) {
            $this->savePreferences($INPUT->post->arr('pref'));
        }
    }

    /**
     * output appropriate html
     */
    public function html()
    {
        global $INPUT;

        echo '<div class="plugin_cite">';

        echo $this->locale_xhtml('intro');

        echo '</div>';
    }
}
