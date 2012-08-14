<div class="node<?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>" id="node-<?php print $node->nid; ?>">

  <?php if ($page == 0): ?>
    <h2 class="title">
      <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
    </h2>
  <?php endif; ?>
<p class="forum-link"><a href="/forum">&lt; <?php print ('Back to Forum Homepage') ?></a></p>

<!-- Start forum posts - with table -->
<div class="content-info-wrapper">
	<table class="forum-table">
		<tr>
			<td width="175" valign="top" align="left" style="border-right: 1px solid #CCCCCC; padding: 10px;">

<div class="old-post-information"> 
  <?php if ($submitted): ?>
    <span class="submitted">
		<?php print t('Posted: '); ?>
		<span><?php print date("F jS, Y", $node->created); ?></span>
		<br/>
		<br/>
		<?php print t(' By: '); ?>
		<span><?php print theme('username', $node); ?></span>
		</span> 
  <?php endif; ?>
 <?php if ($picture) print $picture; ?> 
</div><!-- Close Post Information -->
			</td>

			<td valign="top" align="left" style="padding: 10px;">
<div class="old-forum-content">
  <div class="content">
    <?php print $node->content['body']['#value'] ?>
  </div>
</div><!-- Close Forum Content -->
			</td>
	</tr>
</table>
</div><!-- Close content-info-wrapper -->
<!-- END forum posts - with table -->

<?php print $node->content['forum_navigation']['#value'] ?>

<?php if ($links): ?>
   <div class="links">
     <?php print $links; ?>
   </div>
 <?php endif; ?>

</div>