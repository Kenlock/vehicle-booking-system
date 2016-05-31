<?php // Strat content ?>

<div class="wrap">
  <h1>Vehicle Booking System - Help</h1>
</div>

<h2 class="nav-tab-wrapper">
  <a id="guide" class="nav-tab nav-tab-active" href="<?php echo admin_url() ?>/index.php?page=vbs-docs">Quick Guide</a>
  <a id="credits" class="nav-tab" href="<?php echo admin_url() ?>/index.php?page=vbs-docs">Credits</a>
</h2>

<div id="sections">
  <section>
    <h2>FAQ</h2>
    <ul id="faq">
      <li>
        <span>How did this plugin come to be?</span>
        This plugin was initially created as a proof oc concept. We wanted to see if a booking system for taxi and other distance-based faring services could be build ontop of a Wordpress installation. Turns out it can. However, the plugin will only serve as a biolerplate. Anyone wishing to implement it will probably need to customize it further in order to fit their specific needs.
      </li>
      <li>
        <span>Why not submit it to the Wordpress plugin directory?</span>
        We just like GitHub better... Maybe we will at some point, when we think the plugin is mature enough.
      </li>
      <li>
        <span>How come you are not selling this?</span>
        Just as we mentioned eariler, this is a very basic system, although it includes about 80% of a turn-key solution. We though it was a better idea to just distrubute it for free and see how it evolves.
      </li>
      <li>
        <span>I would like to use it!</span>
        Please, do so! We will be happy to hear from you. Send us your URL and any feedback you may have.
      </li>
      <li>
        <span>I would like feature X added</span>
        You can contact us at <a href="mailto:info@interactive-design.gr">info@interactive-design.gr</a> and we will give you a quote.
      </li>
      <li>
        <span>Will the feature you add for me be rolled out to your GitHub repo?</span>
        It depends. If you request a feature that is too specific to your business, then no. Otherwise, we will ask for your permission to do so.
      </li>
      <li>
        <span>Can I contribute?</span>
        Sure you can! Just fork us or create a pull request. We will then evaluate your additions and maybe implememt them!
      </li>
    </ul>
  </section>
  <section>
    <h3>Third-party libraries</h3>
    <ul>
      <li><a href="https://metabox.io/" target="_blank">Metabox</a></li>
      <li><a href="https://hpneo.github.io/gmaps/" target="_blank">gmaps.js</a></li>
      <li><a href="https://reduxframework.com/" target="_blank">Redux Framework</a></li>
    </ul>

    <h3>People</h3>
    <ul>
      <li>George Nikolopoulos</li>
    </ul>
  </section>
</div>

<div id="help_side">
  <h3>Need customization?</h3>
  <p>Contact us at <a href="mailto:info@interactive-design.gr">info@interactive-design.gr</a> if you need to customize this plugin to fit your specific needs.<br />
  Be sure to send us a detailed description of what you need so we can provide you with an accurate quote.</p>
</div>

<script type="text/javascript">
(function($) {

  $('section').eq(1).hide();

  $(document).on( 'click', '.nav-tab-wrapper a', function() {
    $('section').hide();
    $('section').eq($(this).index()).show();
    $('.nav-tab').removeClass('nav-tab-active');
    $('.nav-tab').eq($(this).index()).addClass('nav-tab-active');
    return false;
  })

})( jQuery );
</script>

<?php // end content ?>