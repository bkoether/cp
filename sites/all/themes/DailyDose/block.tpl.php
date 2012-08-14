<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="block block-<?php print $block->module ?>">  
  <div class="blockinner">
    <h2 class="title"><?php print t($block->subject); ?></h2>
    <div class="content">
      <?php print $block->content; ?>
    </div>    
  </div>
</div>
