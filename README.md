# Google Analytics for DokuWiki

## License

* **Author**: [Terence J. Grant](mailto:tjgrant@tatewake.com)
* **License**: [GNU GPL v2](http://opensource.org/licenses/GPL-2.0)
* **Latest Release**: v1.0.1 on Sep 14th, 2020
* **Changes**: See [CHANGELOG.md](CHANGELOG.md) for full details.
* **Donate**: [Donations](http://tjgrant.com/wiki/donate) and [Sponsorships](https://github.com/sponsors/tatewake) are appreciated!

## About

This tool allows you to set a code for use with [Google Analytics](https://en.wikipedia.org/wiki/Google_Analytics), which allows you to track your visitors.

The plugin also exports a function for use with your template, so you will have to insert the following code into your template (**main.php**), somewhere inside of the `<head></head>` tags.

	<?php
	if (file_exists(DOKU_PLUGIN.'googleanalytics/code.php')) include_once(DOKU_PLUGIN.'googleanalytics/code.php');
	if (function_exists('ga_google_analytics_code')) ga_google_analytics_code();
	?>

**Note**: Inserting the code above is **required**, not optional.

**Template Authors Note**: You can insert the above code and make your template "Google Analytics Ready", even if your users do not use Google Analytics (or have this plugin.)

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
