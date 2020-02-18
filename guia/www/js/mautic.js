/**
 * @Mautic Tracking Code
 * @Tracking code works on Hybrid Apps did you Know that?? Nice!
 * */
(function (w, d, t, u, n, a, m) {
    w['MauticTrackingObject'] = n;
    w[n] = w[n] || function () {
        (w[n].q = w[n].q || []).push(arguments)
    }, a = d.createElement(t),
            m = d.getElementsByTagName(t)[0];
    a.async = 1;
    a.src = u;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://inbound.citywatch.com.br/mtc.js', 'mt');

mt('send', 'pageview');