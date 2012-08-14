<div class="<?php print $node_classes ?>" id="node-<?php print $node->nid; ?>">

  <?php if ($page == 0): ?>
    <h2 class="title">
      <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>

  <div class="content">
    <?php print $content; ?>
  </div>
  
  <?php if ($links): ?>
    <div class="links">
      <?php print $links; ?>
    </div>
  <?php endif; ?>
 
</div>
