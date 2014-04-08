<?php

$shortname = 'shaunpersad';
$identifier = false;
$title = false;
$url = false;

if (@$vars->identifier) {
    $identifier = $vars->identifier;
}
if (@$vars->title) {
    $title = $vars->title;
}
if (@$vars->url) {
    $url = $vars->url;
}

?>


<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'shaunpersad'; // required: replace example with your forum shortname
    <?php


    if (is_string($identifier)) { ?>

        var disqus_identifier = <?=json_encode($identifier)?>;
    <?php
    }

    if (is_string($title)) { ?>

        var disqus_title = <?=json_encode($title)?>;
    <?php
    }

    if (is_string($url)) { ?>

        var disqus_url = <?=json_encode($url)?>;
    <?php
    } ?>


    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
    