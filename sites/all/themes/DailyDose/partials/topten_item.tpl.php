<?php
  $terms = taxonomy_node_get_terms_by_vocabulary($node->nid, 3);
  if ($terms) {
    foreach ($terms as $term) {
      break;
    }
  }
?>

<div class="top-10-container">
  <div class="taxonomy-right"><?php print t($term->name) ?></div>
  <div class="top10-title"><?php print $node->field_top_ten[0]['value'] ?></div>
  <div class="view-field view-top10-date"><?php print format_date($node->created, 'custom', 'F jS, Y') ?></div>
  <div class="view-field view-top10-title"><?php print l($node->title, 'node/'.$node->nid); ?></div>
  <div class="view-field view-topten-annotation"><?php print $node->field_annotations[0]['value'] ?></div>
</div>