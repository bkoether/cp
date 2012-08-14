<h5 class="lbb_listing">
<?php
if (user_access('administer black book')) {
  print l($node->title, 'node/' . $node->nid);
} else {
  print $node->title;
}
?>
</h5>
<p class="lbb_description"><?php print $node->field_description[0]['value'] ?></p>
<div class="lbb_info">
  <?php print $node->field_location[0]['view'] ?>
  <?php print $node->field_phone[0]['value'] ?><br />
  <a target="_blank" href="http://<?php print $node->field_website[0]['url'] ?>"><?php print $node->field_website[0]['url'] ?></a>
  <br/>
  <?php print vitamin_city_gmap_link($node->field_location[0]['lid']) ?>
</div>
