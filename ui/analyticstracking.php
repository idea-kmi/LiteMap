<!-- Google tag (gtag.js) -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Function to check if the user has given consent
    function hasConsent() {
      const consent = localStorage.getItem('cookieConsent');
      return consent !== null && consent === 'true';
    }

    if (hasConsent()) {
      var script = document.createElement('script');
          script.async = true;
          script.src = "https://www.googletagmanager.com/gtag/js?id=<?php print($CFG->GOOGLE_SITE_TAG);?>";
          document.head.appendChild(script);

      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php print($CFG->GOOGLE_SITE_TAG);?>');

      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '<?php print($CFG->GOOGLE_ANALYTICS_KEY);?>', '<?php print($CFG->GOOGLE_ANALYTICS_DOMAIN);?>');
      ga('require', 'linkid', 'linkid.js');
      ga('send', 'pageview');
    }
  });
</script>
