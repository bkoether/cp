<div class="daily-dose">

  <?php
    /**
     * display date base on $node->created if the scheduler has not been used
     * or the scheduled time if it was publish via the scheduler. ATTENTION:
     * this required the hacking of the scheduler.module.
     */
    $city = vitamin_city_current_city();
    $result = db_query('SELECT publish_on, timezone FROM scheduler WHERE nid = %d', $node->nid);
    while($pub = db_fetch_object($result)) {
      $pubon = $pub->publish_on;
      $pubzo = $pub->timezone;
    }
    //account for timezone + server's timezone
    $pubti = $pubon + str_replace('-', '', $pubzo) + 10800;
    $pdate = $pubon ? $pubti : $node->created;
		
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
  <span class="date"><p><?php print format_date($pdate, 'custom', "F jS, Y") ?></p></span>

    <h2 class="title-full"><?php print $title; ?></h2>

  <?php if (arg(0) != 'archive'): ?>
  <div class="meta-block">
    <?php
      if (count($taxonomy)) {
        $mytags = '';
        print '<div class="dose-links">';
        foreach($node->taxonomy as $term) {
          //Free tags
          if($term->vid == 1) {
            $mytags .= l($taxonomy['taxonomy_term_'. $term->tid]['title'], $city->field_city_url_path[0]['value'] .'/tag/' . $term->tid) .', ';
          }
          //Topic
          elseif($term->vid == 3) {
            $mytopic = $term->name;
          }
        }
        $path = vitamin_city_topic_path($mytopic);
        print '<h4>'. l(t($mytopic), $city->field_city_url_path[0]['value'] . '/' . $path) .'</h4>';
        print '<h5>' . t('MAKE IT YOURS') . '</h5>';
        if($links) {
          $links = $node->links;
          print '<div class="links"><ul>';
          foreach($links as $link) {
            if(!preg_match('/[0-9]* reads?/i', $link['title'])) {
              $attributes = ($link['attributes']) ? $link['attributes'] : array();
              if($node->field_map_link[0]['url'] != '') {
                print '<li>';
              }
              else{
                print '<li class="last">';
              }
              $link['title'] = str_replace('Email this page', t('SEND TO A FRIEND'), $link['title']);
              $mytitle = t($link['title']);
              print l(strtoupper($mytitle), $link['href'], $attributes) .'</li>';
              print '<!-- DEBUG: ' . $mytitle . ' -->';
            }
          }
          
          if($node->field_map_link[0]['url'] != '') {
            print '<li class="last">'. l(t('GOOGLE MAP'), $node->field_map_link[0]['url']) .'</li>';
          }
          print '</ul></div>';
        }
        
        $related_doses = related_nodes_display_related($node->nid);
        if ($related_doses) {
          print '<h5>' . t('RELATED DOSES') . '</h5>';
          print '<div class="links">';
          print $related_doses;
          print '</div>';
        }

        if($mytags != '') {
          print '<h5>' . t('TAGS') . '</h5>';
          print '<p>'. substr($mytags, 0, -2) .'</p>';
        }
        print '</div>';
      }
    ?>
  </div>
  <?php endif; ?>

  <div class="content">
    <?php print $node->content['body']['#value']; ?>
  </div>

  <div class="thesocial">
		<ul>
			<li class="tweetthis"><a href="#">Tweet this</a></li>
			<li class="fblike"><fb:like href="<?php echo url("node/{$node->nid}", NULL, NULL, true) ?>" layout="button_count" show_faces="false"></fb:like></li>
		</ul>
  </div>

  <?php
    if(arg(0) == 'node') {
      vitamin_city_display_ad('ad_inline_300x250_ros');
    }
  ?>
</div>
