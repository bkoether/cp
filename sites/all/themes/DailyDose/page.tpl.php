<?php

  $city = vitamin_city_current_city();
  //social media links are here because they are unique per city

  switch($city->nid){
    case 3332:
    case 3333:
      $tlink = "http://twitter.com/MTLVitaminDaily";
      $ilink = "http://itunes.apple.com/ke/app/vitaminmtl/id451188534?mt=8";

      break;
    case 3496:
      $tlink = "http://twitter.com/VitaminDailyCal";
      $ilink = "http://itunes.apple.com/ca/app/vitamincal/id451186288?mt=8";

      break;  
    case 3331:
    default:
      $tlink = "http://twitter.com/vitamindailytor";
      $ilink = "http://itunes.apple.com/ca/app/vitaminto/id451180336?mt=8";
     
      break;              
  }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language ?>" xml:lang="<?php print $language ?>">

<head>
  <title><?php print $head_title ?></title>
  <?php
  // RCS: modified $head to show city specific favicon AUF 070921
  print preg_replace ('/themes\/DailyDose\/favicon.ico/', 'files/' . $city->field_favicon[0]['value'], $head);
    
//  if(strtolower($_SERVER['HTTP_HOST']) == 'vitamint.ca' ) {
//    print preg_replace ('/themes\/DailyDose\/favicon.ico/', 'files/tor_favicon.ico', $head);
//  } elseif(strtolower($_SERVER['HTTP_HOST']) == 'vitaminm.ca' ) {
//    print preg_replace ('/themes\/DailyDose\/favicon.ico/', 'files/mtl_favicon.ico', $head);
//  } else  {
//    print preg_replace ('/themes\/DailyDose\/favicon.ico/', 'files/van_favicon.ico', $head);
//  }
?>
  <?php print $head; ?>
<link rel="stylesheet" href="http://f.fontdeck.com/s/css/D8Fz3XWt+VC0VDejQHe7Mks5Qzc/vitamindaily.com/18728.css" type="text/css" />  <?php print $styles; ?>
  <?php print $scripts; ?>

	<link rel="shortcut icon" href="/<?php print $city->field_icon_image[0]['filepath'] ?>" type="image/x-icon" />

  <?php // change sIFR color based on the city
      $sColor = '#' . $city->field_color[0]['value'];
      $sLinkColor = '#' . $city->field_link_color[0]['value'];
      $sBgColor = '#' . $city->field_background_color[0]['value'];
      $sHoverColor = '#' . $city->field_hover_color[0]['value'];
  ?>
  <script type="text/javascript" src="/themes/DailyDose/jquery.tweet.js"></script>
	<script type="text/javascript" charset="utf-8">
  $(function() {
		var account = $(".tweet").attr('id');
		$(".tweet").tweet({
			username: account,
			join_text: null,
			avatar_size: 0,
			count: 5,
			auto_join_text_default: null, 
			auto_join_text_ed: null,
			auto_join_text_ing: null,
			auto_join_text_reply: null,
			auto_join_text_url: null,
			loading_text: "loading tweets..."
		});
  });		
	</script>
<!--<script type="text/javascript" src="/themes/DailyDose/sifr/sifr.js"></script> -->
  <script type="text/javascript">
  //<![CDATA[
    /* sIFR Replacement calls. */
			//     if(typeof sIFR == "function"){
			// sIFR.replaceElement(named({sSelector:".main-content .node h2.title", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sCase:"upper", sColor:"<?php print $sColor ?>", sLinkColor:"<?php print $sLinkColor ?>", sBgColor:"<?php print $sBgColor ?>", sHoverColor:"<?php print $sHoverColor ?>" , sWmode:"transparent",  nPaddingTop:-2, nPaddingBottom:0, sFlashVars:"underline=true"}));
			// sIFR.replaceElement(named({sSelector:".node .content h3.lbb_subtitle", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sCase:"upper", sColor:"#444444", sLinkColor:"#444444", sBgColor:"<?php print $sBgColor ?>", sHoverColor:"<?php print $sHoverColor ?>" , sWmode:"transparent",  nPaddingTop:-2, nPaddingBottom:-2, sFlashVars:"underline=true"}));
			// sIFR.replaceElement(named({sSelector:"div.daily-dose h2.title", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sCase:"upper", sColor:"<?php print $sColor ?>", sLinkColor:"<?php print $sLinkColor ?>", sBgColor:"<?php print $sBgColor ?>", sHoverColor:"<?php print $sHoverColor ?>" , sWmode:"transparent",  nPaddingTop:-10, nPaddingBottom:-4, sFlashVars:"underline=true"}));
			// sIFR.replaceElement(named({sSelector:".main-content h1.title", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sCase:"upper" ,sColor:"<?php print $sColor ?>", sLinkColor:"<?php print $sLinkColor ?>", sBgColor:"<?php print $sBgColor ?>", sHoverColor:"<?php print $sHoverColor ?>" , sWmode:"transparent",  nPaddingTop:-2, nPaddingBottom:0, sFlashVars:"underline=true"}));
			// sIFR.replaceElement(named({sSelector:".node .content h2", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sCase:"upper", sColor:"<?php print $sColor ?>", sLinkColor:"<?php print $sLinkColor ?>", sBgColor:"<?php print $sBgColor ?>", sHoverColor:"<?php print $sHoverColor ?>" , sWmode:"transparent",  nPaddingTop:-2, nPaddingBottom:0, sFlashVars:"underline=true"}));
			// sIFR.replaceElement(named({sSelector:".node .content h4", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sCase:"upper", sColor:"<?php print $sColor ?>", sLinkColor:"<?php print $sLinkColor ?>", sBgColor:"<?php print $sBgColor ?>", sHoverColor:"<?php print $sHoverColor ?>" , sWmode:"transparent",  nPaddingTop:-2, nPaddingBottom:0, sFlashVars:"underline=true"}));
			// sIFR.replaceElement(named({sSelector:"div.daily-dose h2.title-full", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sCase:"upper", sColor:"<?php print $sColor ?>", sLinkColor:"<?php print $sLinkColor ?>", sBgColor:"<?php print $sBgColor ?>", sHoverColor:"<?php print $sHoverColor ?>" , sWmode:"transparent",  nPaddingTop:0, nPaddingBottom:0, sFlashVars:"underline=true"}));
			// sIFR.replaceElement(named({sSelector:"#myfavourites .afavourite .date", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sColor:"#666666", sBgColor:"<?php print $sBgColor ?>", sWmode:"transparent",  nPaddingTop:0, nPaddingBottom:0, sFlashVars:"underline=true"}));
			// sIFR.replaceElement(named({sSelector:"#myfavourites .afavourite h4", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sCase:"upper", sColor:"<?php print $sColor ?>", sBgColor:"<?php print $sBgColor ?>", sWmode:"transparent",  nPaddingTop:0, nPaddingBottom:0, sFlashVars:"underline=true"}));
			// sIFR.replaceElement(named({sSelector:"#myfavourites .afavourite .topic", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sColor:"<?php print $sColor ?>", sBgColor:"<?php print $sBgColor ?>", sWmode:"transparent",  nPaddingTop:0, nPaddingBottom:0, sFlashVars:"underline=true"}));
			//     }
  //]]>
  </script>

<!-- Needed for Uptrends Ad Code to work -->
	<script type="text/javascript">
	//<![CDATA[
	var ord=Math.random()*10000000000000000;
	//]]>
	</script>

	<style type="text/css" media="screen">
/*	.sIFR-hasFlash .main-content .node h2.title { visibility: hidden; }
	.sIFR-hasFlash div.daily-dose h2.title { visibility: hidden; }
	.sIFR-hasFlash div.daily-dose h2.title-full { visibility: hidden; }
	.sIFR-hasFlash .node .content h2 { visibility: hidden; }
	.sIFR-hasFlash .node .content h4 { visibility: hidden; }
	.sIFR-hasFlash #myfavourites .afavourite .date { visibility: hidden; }
	.sIFR-hasFlash #myfavourites .afavourite h4 { visibility: hidden; }
	.sIFR-hasFlash #myfavourites .afavourite .topic { visibility: hidden; }
	.sIFR-flash { visibility: visible !important; margin: 0; }
	.sIFR-replaced { visibility: visible !important; }
	span.sIFR-alternate { position: absolute; left: 0; top: 0; width: 0; height: 0; display: block; overflow: hidden; }*/
	</style>


	<!--[if lte IE 6]>
	<style type="text/css" media="all">@import "/sites/DailyDose/DailyDose/ie6.css";</style>
	<![endif]-->
	<!--[if IE 7]>
	<style type="text/css" media="all">@import "/sites/DailyDose/DailyDose/ie7.css";</style>
	<![endif]-->
	

</head>
<body class="<?php print $body_classes; ?>" id="<?php print $city->field_city_url_path[0]['value'] ?>">
<div id="accessibility" >
	<a href="#main">Skip to Content</a>
</div>

  <div id="container">
	   
     <div style="width:728px;margin:10px auto">
       <?php print DailyDose_rogersAd('leader', $city->nid, arg(1)); //rogers ads - leaderboard ?>
     </div>
	
      <div id="sidebar-right" class="column sidebar">
        <?php print $sidebar_right; ?>
        <?php print DailyDose_rogersAd('bigbox', $city->nid, arg(1)); //rogers ads - bigbox ?>
        <div style="width:160px;margin:10px auto"><?php print DailyDose_rogersAd('skyscraper', $city->nid, arg(1)); //rogers ads - skyscraper ?></div>
      </div> <!-- /sidebar-right -->

<div id="holds-content"><!-- Wraps header - footer - main content and left sidebar -->
<div id="inner-wrapper"><!-- Needed to place let side ornament image -->
    <div id="header">

<?php print $feed_icons; ?>

        <?php if ($logo): ?>
          <a href="<?php print $base_path; ?>" title="<?php print t('Home'); ?>">
            <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" id="logo" />
          </a>
        <?php endif; ?>

    <div id="name-and-slogan">
        
        <?php if ($site_name): ?>
          <h1 id='site-name'>
            <a href="<?php print $base_path ?>" title="<?php print t('Home'); ?>">
              <?php print $site_name; ?>
            </a>
          </h1>
        <?php endif; ?>
        
        <?php if ($site_slogan): ?>
          <div id='site-slogan'>
            <?php print $site_slogan; ?>
          </div>
        <?php endif; ?>
        
    </div> <!-- /name-and-slogan -->

      
      <?php if ($header || $breadcrumb): ?>
        <div id="header-region">
          <?php print $header; ?>
					<div id="social-list">
						<a href="http://www.facebook.com/vitamindaily1" title="Like us on Facebook" id="social-facebook"></a>
						<a href="http://pinterest.com/vitamindaily/" title="Follow our boards on Pinterest" id="social-pintrest"></a>
						<a href="<?php print $tlink;?>" title="Follow us on Twitter" id="social-twitter"></a>
						<a href="<?php print $ilink;?>" title="Download the Vitamin Daily app from the App Store" id="social-appstore"></a>
					</div>

        </div>
      <?php endif; ?>
      
    </div> <!-- /header -->

    <div id="content" class="clear-block">
                  
      <?php if ($sidebar_left): ?>
        <div id="sidebar-left" class="column sidebar">
          <?php print $sidebar_left; ?>
        </div> <!-- /sidebar-left -->
      <?php endif; ?>  
    
 

      <div id="main" class="column main-content">
        <?php if(drupal_is_front_page()) print $messages; ?>
        <?php if ($content_top):?><div id="content-top"><?php print $content_top; ?></div><?php endif; ?>
	<div id="inner-main">
        <?php if ($mission): ?><div id="mission"><?php print $mission; ?></div><?php endif; ?>
        <?php if ($title && $node->type != 'daily_dose'): ?>
					<h1 class="title">
					<?php switch ($title) {
						case "Contact" : print t("Contact Us"); break;
						case "Forums" : print t("Our Forums"); break;
					default : print $title; break;
					}
					?>
		</h1><?php endif; ?>
        
				<?php if ($below_title):?><div id="below-title"><?php print $below_title; ?></div><?php endif; ?>
        <?php if ($tabs): ?><div class="tabs"><?php print $tabs; ?></div><?php endif; ?>
        <?php print $help; ?>
        <?php if(!drupal_is_front_page()) print $messages; ?>
        <?php print $content; ?>
        <?php print $feed_icons; ?>
        <?php if ($content_bottom): ?><div id="content-bottom"><?php print $content_bottom; ?></div><?php endif; ?>

				 <div id="footer">
		        <?php print $footer_message; ?>
		     </div> <!-- /footer -->
	     </div> <!-- /inner-main -->
       </div> <!-- /main -->

	
      </div> <!-- /content -->
    </div> <!-- /inner-wrapper -->

<div class="site_credit">&nbsp;</div>
 <!-- /holds content -->

    <?php print $closure; ?>
    <?php print DailyDose_rogersAd('1x1', $city->nid, arg(1)); //rogers ads - 1x1 ?>
    
  </div> <!-- /container -->
	<script type="text/javascript" src="http://tweet-it.st.pongsocket.com/tweet-it.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".tweetthis a").tweetIt({
			animate: "fade",
			cssFile: "<?php echo url("themes/DailyDose/style.css", NULL, NULL, true) ?>",
			header: "140 characters go!"
		});
	})
	</script>
	<div id="fb-root"></div>
	<script>
	  window.fbAsyncInit = function() {
	    FB.init({appId: '142383032443068', status: true, cookie: true,
	             xfbml: true});
	  };
	  (function() {
	    var e = document.createElement('script'); e.async = true;
	    e.src = document.location.protocol +
	      '//connect.facebook.net/en_US/all.js';
	    document.getElementById('fb-root').appendChild(e);
	  }());
	</script>
	<!-- <?php print $city->nid;?> -->
</body>
</html>
<?php// } ?>