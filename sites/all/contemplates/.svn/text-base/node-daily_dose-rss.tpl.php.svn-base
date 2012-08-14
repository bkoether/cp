<div class="field field-type-content field-field-content">
  <div class="field-items">
	 <?php print $node->content['body']['#value'] ?>
  </div>
</div>
	
	
<div class="meta-block">
  <?php
    if (count($taxonomy)) {
      $mytags = '';
      print '<div class="dose-links">';
      foreach($node->taxonomy as $term) {
        //Free tags
        if($term->vid == 1) {
					foreach($taxonomy as $v) {
					  if($v->vid == 2) {
						if($v->name == 'Montréal') {
							$city = 'montreal_fr';
						} else {
							$city = $v->name;
						}
					}
					}
          $mytags .= l($term->name, strtolower($city) .'/tag/' . $term->tid,  array(), NULL, NULL, TRUE) .', ';
        }
        //Topic
        elseif($term->vid == 3) {
          $mytopic = $term->name;
        }
      }
      $path = vitamin_city_topic_path($mytopic);
      print '<h4 color: #444444!important;>'. t($mytopic) .'</h4>';

       if($node->field_map_link[0]['url'] != '') {
         print '<h5>MAKE IT YOURS</h5><div><ul><li class="last">'. l(t('GOOGLE MAP'), $node->field_map_link[0]['url']) .'</li></ul></div>';
       }
     
      $related_doses = related_nodes_display_related($node->nid);
      if ($related_doses) {
        print '<h5 style="color: #444444!important;">' . t('RELATED DOSES') . '</h5>';
        print '<div class="links">';
        print $related_doses;
        print '</div>';
      }

      if($mytags != '') {
        print '<h5 style="color: #444444!important;">' . t('TAGS') . '</h5>';
        print '<p>'. substr($mytags, 0, -2) .'</p>';
      }
      print '</div>';
    }
  ?>
</div>

