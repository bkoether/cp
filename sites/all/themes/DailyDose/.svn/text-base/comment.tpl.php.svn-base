<div class="comment forum-comment <?php if ($comment->status == COMMENT_NOT_PUBLISHED) print ' comment-unpublished'; ?>">
<table class="forum-table">
	<tr>
		<td width="175" valign="top" align="left" style="border-right: 1px solid #CCCCCC; padding: 10px;">
<div class="old-post-information"> 
<?php if ($picture) print $picture; ?> 
<span class="submitted">
	<span style="color: #A6519B;"><?php print date("F jS, Y", $comment->timestamp); ?></span>
	<br/>
	<br/>
	<?php print t(' By: '); ?>
	<br/>
	<span style="color: #A6519B;"><?php print theme('username', $comment); ?></span>
	</span> 
</div><!-- Close Post Information -->
		</td>
		<td valign="top" align="left" style="padding: 10px;">
			<div class="old-comment-content">
				<?php if ($new != '') { ?><span class="new" style="color: #CC0000;"><?php print $new; ?></span><?php } ?>
			    <h3 class="title"><?php print $title; ?></h3>
			    <div class="content"><?php print $content; ?></div>
			    <div class="links"><?php print $links; ?></div>
			</div><!-- Close Content -->
		</td>
</tr>
</table>
</div>
