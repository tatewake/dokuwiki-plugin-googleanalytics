/**
 * Set up Google analytics
 *
 * All configuration is done in the JSINFO.ga object initialized in
 * action.php
 */
if (JSINFO.ga) {
    /* default google tracking initialization */
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        //noinspection CommaExpressionJS
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        //noinspection CommaExpressionJS
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    // initalize and set options
    ga('create', JSINFO.ga.trackingId, 'auto', JSINFO.ga.options);
    ga('set', 'forceSSL', true);
    ga('set', 'anonymizeIp', JSINFO.ga.anonymizeIp);

    // track pageview and action
    ga('set', 'dimension1', JSINFO.ga.action);
    ga('set', 'dimension2', JSINFO.ga.id);
    ga('send', 'pageview', JSINFO.ga.pageview);
    ga('send', 'event', 'wiki-action', JSINFO.ga.action, JSINFO.id, {
        nonInteraction: true // this is an automatic event with the page load
    });

    // track outgoing links, once the document was loaded
    if (JSINFO.ga.trackOutboundLinks) {
        jQuery(function () {
            // https://support.google.com/analytics/answer/1136920?hl=en
            jQuery('a.urlextern, a.interwiki').click(function (e) {
                e.preventDefault();
                var url = this.href;
                ga('send', 'event', 'outbound', 'click', url, {
                    'transport': 'beacon',
                    'hitCallback': function () {
                        document.location = url;
                    }
                });
            });
        });
    }
}
