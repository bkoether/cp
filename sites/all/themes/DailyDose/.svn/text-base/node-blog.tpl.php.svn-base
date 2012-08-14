<div class="<?php print $node_classes ?>" id="node-<?php print $node->nid; ?>">

  <?php
    /**
     * display date base on $node->created if the scheduler has not been used
     * or the scheduled time if it was publish via the scheduler. ATTENTION:
     * this required the hacking of the scheduler.module.
     */

    $result = db_query('SELECT publish_on FROM scheduler WHERE nid = %d', $node->nid);
    while($pub = db_fetch_object($result)) {
      $pubon = $pub->publish_on;
    }
    //TODO: account for timezone
    $pdate = $pubon ? $pubon : $node->created;
    
    // set the opengraph meta data for facebook like widget
		$og_metas = '<meta property="og:site_name" content="Vitamin Daily - ' . $city->title . '"/>' . "\n";
		$og_metas .= '<meta property="og:title" content="' . $title . '"/>' . "\n";
		$og_metas .= '<meta property="og:url" content="' . url("node/{$node->nid}", NULL, NULL, true) . '"/>' . "\n";
		$og_metas .= '<meta property="fb:app_id" content="142383032443068"/>' . "\n";
		$og_metas .= '<meta property="og:type" content="article" />' . "\n";
		$og_metas .= '<meta property="og:image" content="' . url($node->field_image_1[0]['filepath'], NULL, NULL, true) . '"/>' . "\n";
		// canonical link for tweet
		// $tweet_link = '<link rev="canonical" type="text/html" href="' . url("node/{$node->nid}", NULL, NULL, true) . '" />' . "\n";
		// $head_stuff = $og_metas . $tweet_link;
		drupal_set_html_head($og_metas);

  ?>


  <?php if ($page == 0): ?>
    <h2 class="title">
      <a href="<?php print $node_url ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>

  <?php if ($submitted): ?>
     <span class="submitted" style="float: right;"><?php print t('Posted ') . t(' by ') . theme('username', $node) . t(' at ') . format_date($pdate, 'custom', "g:i a"); ?></span> 
   <?php endif; ?>
  <span class="date"><p><?php print format_date($pdate, 'custom', "F jS, Y") ?></p></span>

  <?php if ($picture) print $picture; ?>  
   
  <div class="content">
    <?php print $content; ?>
  </div>

  <div class="thesocial">
		<ul>
			<li class="tweetthis"><a href="#">Tweet this</a></li>
			<li class="fblike"><fb:like href="<?php echo url("node/{$node->nid}", NULL, NULL, true) ?>" layout="button_count" show_faces="false"></fb:like></li>
		</ul>
  </div>

  <?php if ($links): ?>
    <div class="links">
      <?php print $links; ?>
    </div>
  <?php endif; ?>
 
 <?php if (count($taxonomy)): ?>
    <div class="taxonomy"><?php print t('Categories') . ': ' . $terms ?></div>
  <?php endif; ?>

</div>
