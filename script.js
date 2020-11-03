/**
 * Set up Google analytics
 *
 * All configuration is done in the JSINFO.ga object initialized in
 * action.php
 */
if (JSINFO.ga) {
    if (JSINFO.ga.gtagId) {
        /* Global site tag (gtag.js) - Google Analytics */

        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://www.googletagmanager.com/gtag/js?id=' + JSINFO.ga.gtagId;

        document.body.appendChild(script);

        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', JSINFO.ga.gtagId);
    } else {
        /* default google tracking initialization */
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            //noinspection CommaExpressionJS
            i[r] = i[r] || function() {
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

        // The hit payload is also send to the console
        // https://developers.google.com/analytics/devguides/collection/analyticsjs/tasks#overriding_a_task
        if (JSINFO.ga.debug) {

            ga(function(tracker) {

                // Grab a reference to the default sendHitTask function.
                var originalSendHitTask = tracker.get('sendHitTask');

                // Overwrite and add an output to the console
                tracker.set('sendHitTask', function(model) {
                    originalSendHitTask(model);
                    console.log("Doku Google Analytics Plugin Debug: Hit Payload: " + model.get('hitPayload'));
                });

            });

        }

        // track outgoing links, once the document was loaded
        if (JSINFO.ga.trackOutboundLinks) {

            jQuery(function() {
                // https://support.google.com/analytics/answer/1136920?hl=en
                jQuery('a.urlextern, a.interwiki').click(function() {
                    var url = this.href;
                    if (ga && ga.loaded) {
                        ga('send', 'event', 'outbound', 'click', url, {
                            'transport': 'beacon'
                        });
                    }
                });
            });

        }
    }
}