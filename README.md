# Google Analytics for DokuWiki

## License

* **Author**: [Terence J. Grant](mailto:tjgrant@tatewake.com)
* **License**: [GNU GPL v2](http://opensource.org/licenses/GPL-2.0)
* **Latest Release**: v1.1.0 on Nov 3rd, 2020
* **Changes**: See [CHANGELOG.md](CHANGELOG.md) for full details.
* **Donate**: [Donations](http://tjgrant.com/wiki/donate) and [Sponsorships](https://github.com/sponsors/tatewake) are appreciated!

## About

This tool allows you to set a code for use with [Google Analytics](https://en.wikipedia.org/wiki/Google_Analytics), which allows you to track your visitors.

This plugin generates JavaScript code that is automatically included into your site via the `lib/exe/js.php` file. (Which you can inspect via your browser's "developer tools.")

Set the options for this plugin via the **Configuration Settings** menu from the DokuWiki admin menu. (It will be near the bottom of the page.)

You may use one of two tracking options:

  * **Basic** "Google Analytics ID" (also known as "[analytics.js](https://developers.google.com/analytics/devguides/collection/analyticsjs)") using a **UA-XXXXXX-XX** code
  * **Newer** "Global Site Tag ID" (also known as "[gtag.js](https://developers.google.com/analytics/devguides/collection/gtagjs)") using a **G-XXXXXXXXXX** code

If you set a "Global Site Tag ID", then this method will be used and any "Google Analytics ID" / **UA-XXXXXXX-XX** specific settings will be ignored.

## Advanced Usage

To use the advanced "tagging" features of `analytics.js` or `gtag.js`, you will need to be able to embed JavaScript within your DokuWiki pages. You can accomplish this in one of three ways:

  * [Enabling embedded HTML](https://www.dokuwiki.org/wiki:syntax#embedding_html_and_php) in your local DokuWiki instance (Look for `htmlok` in Configuration Settings)
  * Allow embedded JavaScript via a plugin like the [InlineJS Plugin](https://www.dokuwiki.org/plugin:inlinejs)
  * Edit your site's template to add "tagging" directly

Allowing embedded HTML / JavaScript will give you the most flexibility for per-page tagging, but it can open your site to [Cross-site Scripting](https://en.wikipedia.org/wiki/Cross-site_scripting) attacks if you're not careful. If you lock down who can edit your wiki pages and trust your users, you should be fine though.

If you edit your template (the third option), make sure to make notes of what you change, as "upgrading" your template will revert any changes you've made.

## Install / Upgrade

Search and install the plugin using the [Extension Manager](https://www.dokuwiki.org/plugin:extension). Refer to [Plugins](https://www.dokuwiki.org/plugins) on how to install plugins manually.

## Setup

All further documentation for this plugin can be found at:

 * [https://www.dokuwiki.org/plugin:googleanalytics](https://www.dokuwiki.org/plugin:googleanalytics)

## Contributing

The official repository for this plugin is available on GitHub:

* [https://github.com/tatewake/dokuwiki-plugin-googleanalytics](https://github.com/tatewake/dokuwiki-plugin-googleanalytics)

The plugin thrives from community contributions. If you're able to provide useful code changes or bug fixes, they will likely be accepted to future versions of the plugin.

If you find my work helpful and would like to give back, [consider joining me as a GitHub sponsor](https://github.com/sponsors/tatewake).

Thanks!

--Terence
