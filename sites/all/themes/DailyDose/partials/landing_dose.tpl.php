<?php
$node = node_load($node->nid);
?>
<div id="dose" class="daily-dose">
  <h2 class="title"><?php print l($node->title, 'node/' . $node->nid) ?></h2>
  <p><?php print word_trim($node->body, '45') ?> ...</p>

<p class="read_more">
<?php 
//HACK! until we make landing a full drupal page
if (preg_match('/vitaminedujour.com$/', $_SERVER['HTTP_HOST'])) {
  $read_more = 'EN SAVOIR PLUS ...';
}
else {
  $read_more = 'READ MORE ...';
}
print l(t($read_more), 'node/' . $node->nid);
?>
</p>
</div>