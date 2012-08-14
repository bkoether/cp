<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language ?>" xml:lang="<?php print $language ?>">
<head>
  <title>Vitamin Daily - Canada's Online Lifestyle Magazine</title>
  <?php print $head; ?>
	<link rel="stylesheet" type="text/css" href="/themes/DailyDose/landing-style.css?v3" />
  <style type="text/css" media="all">@import "/sites/all/modules/thickbox/thickbox.css";</style>

	<link rel="shortcut icon" href="/themes/DailyDose/favicon.ico" type="image/x-icon" />

  <?php // change sIFR color based on the city
      $sColor = '#' . $city->field_color[0]['value'];
      $sLinkColor = '#' . $city->field_link_color[0]['value'];
      $sBgColor = '#' . $city->field_background_color[0]['value'];
      $sHoverColor = '#' . $city->field_hover_color[0]['value'];
  ?>
  <?php print drupal_get_js('header'); ?>
  <!-- video includes: start -->
  <script language="javascript">AC_FL_RunContent = 0;</script>
  <script src="/themes/DailyDose/flv/AC_RunActiveContent.js" language="javascript"></script>
  <!-- video includes: end -->
  <script type="text/javascript" src="/themes/DailyDose/sifr/sifr.js"></script>
  <script type="text/javascript">
  //<![CDATA[
    /* sIFR Replacement calls. */
    if(typeof sIFR == "function"){
			sIFR.replaceElement(named({sSelector:"h2.title", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sCase:"upper", sColor:"<?php print $sColor ?>", sLinkColor:"#a0649a", sBgColor:"<?php print $sBgColor ?>", sHoverColor:"#a0649a" , sWmode:"transparent",  nPaddingTop:-2, nPaddingBottom:0, sFlashVars:"underline=true"}));

			sIFR.replaceElement(named({sSelector:"#signup", sFlashSrc:"/themes/DailyDose/sifr/bryantreg.swf", sCase:"upper", sColor:"<?php print $sColor ?>", sLinkColor:"#a0649a", sBgColor:"<?php print $sBgColor ?>", sHoverColor:"#a0649a" , sWmode:"transparent",  nPaddingTop:-2, nPaddingBottom:0, sFlashVars:"underline=true"}));

}
  //]]>
  </script>

<!-- Needed for Uptrends Ad Code to work -->
	<script type="text/javascript">
	var ord=Math.random()*10000000000000000;
	</script>
	<style type="text/css" media="screen">
	.sIFR-hasFlash .main-content .node h2.title { visibility: hidden; }
	.sIFR-hasFlash div.daily-dose h2.title { visibility: hidden; }
	.sIFR-hasFlash div.daily-dose h2.title-full { visibility: hidden; }
	.sIFR-hasFlash .node .content h2 { visibility: hidden; }
	.sIFR-hasFlash .node .content h4 { visibility: hidden; }
	.sIFR-hasFlash #myfavourites .afavourite .date { visibility: hidden; }
	.sIFR-hasFlash #myfavourites .afavourite h4 { visibility: hidden; }
	.sIFR-hasFlash #myfavourites .afavourite .topic { visibility: hidden; }
	.sIFR-flash { visibility: visible !important; margin: 0; }
	.sIFR-replaced { visibility: visible !important; }
	span.sIFR-alternate { position: absolute; left: 0; top: 0; width: 0; height: 0; display: block; overflow: hidden; }
	</style>

</head>
<body class="<?php print $body_classes; ?>" id="<?php print $city->field_city_url_path[0]['value'] ?>">
	

<div id="container">
	<div id="holds-content">
		<div id="main">

			<div id="city_links">
				<div class="title"><span class="do_not_display">SELECT AN EDITION:</span></div>
				<a href="/montreal" class="montreal" title="Montreal" ><span class="do_not_display">Montreal</span></a>
				<a href="/montreal_fr" class="montreal-fr" title="Montréal" ><span class="do_not_display">Montréal</span></a>
				<a href="/toronto" class="toronto" title="Toronto"><span class="do_not_display">Toronto</span></a>
				<a href="/calgary" class="calgary" title="Calgary"><span class="do_not_display">Calgary</span></a>
				<a href="/vancouver" class="vancouver" title="Vancouver"><span class="do_not_display">Vancouver</span></a>
			</div>
	
			<div id="header">
				<a href="http://vitaminedujour.com" title="En Francaise" id="language_switch"><span class="do_not_display">En Francais</span>&nbsp;</a>
				<img src="themes/DailyDose/images/landing-logo.gif" alt="Welcome to Vitamin Daily" />
			</div>
			<div id="intro">
				<p>Congratulations, you've found Vitamin Daily, Canada's premiere online guide to the good life. Subscribe to our free daily style supplement for the tastiest treats and insider finds right in the city where you live. Vitamin Daily: it's just what the style doctor ordered.</p>
				<div id="signup"><a href="/user/register" title="Sign up!">GET YOUR DAILY DOSE NOW<br />IT'S FREE!</a>	</div>
			</div>
		</div> <!-- #main -->
		<div id="feature_area">
			<div id="search">
                          <!--
				<form id="form" action="/vancouver" method="post" accept-charset="UTF-8">
					<input class="box" type="text" name="search_block_form_keys" />
					<input class="button" type="submit" name="op" id="edit-submit" value="Search" />
					<input type="hidden" name="form_id" id="edit-ssearch-block-form" value="search_block_form" />
					<div id="dropdown">
						<select name="editions">
	 						<option value="all">All Editions</option>
	 						<option value="montreal">Montreal</option>
	 						<option value="toronto">Toronto</option>
	 						<option value="calgary">Calgary</option>
	 						<option value="vancouver">Vancouver</option>
  					</select>
					</div>
				</form>
                        -->
<?php print drupal_get_form('vitamin_city_landing_search_form', 'en') ?>
			</div>
<?php print vitamin_city_landing_dose('en') ?>

    <div id="feature">
    	<a href="#TB_inline?height=336&width=364&inlineId=vd_Video_Thickbox&modal=true" class="thickbox"><img src="/themes/DailyDose/images/promo/dontbeadont.jpg" alt="" /></a>
    </div>

		<div id="footer">
			<div id="nav_bottom"><a href="/montreal">Montreal</a> / <a href="/montreal_fr">Montr&eacute;al</a> | <a href="/toronto">Toronto</a> | <a href="/calgary">Calgary</a> | <a href="/vancouver">Vancouver</a></div>
			<div id="nav_bottom_sub"><a href="/user/register">Sign up</a> | <a href="/user">Unsubscribe</a> | <a href="/advertise">Advertise</a> | <a href="/who-we-are">About Us</a> | <a href="/contact">Contact Us</a> | <a href="/privacy-policy">Privacy Policy</a> | <a href="/terms-of-use">Terms of Use</a> | <a href="/site-help">Help</a></div>
			<div id="copyright">&copy; 2008 Daily Dose Media Inc. All rights reserved.</div>
			<div id="telefilm">
        <img src="/themes/DailyDose/images/telefilm.png" alt="Telefilm Logo" />
        <p>Produced with the financial participation of Telefilm Canada</p>
      </div>
		</div>
	</div> <!-- #holds-content -->
  <?php print drupal_get_js('footer'); ?>
</div> <!-- #container -->
<div id="vd_Video_Thickbox">
  <div id="vd_Video_Inner">
    <input type="image" src="/themes/DailyDose/images/close.gif" onclick="tb_remove()" style="position: relative; left: 331px; top: -7px;" class="vdicon"/>
    <script language="javascript">
    	if (AC_FL_RunContent == 0) {
    		alert("This page requires AC_RunActiveContent.js.");
    	} else {
    		AC_FL_RunContent(
    			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
    			'width', '320',
    			'height', '280',
    			'src', '/themes/DailyDose/flv/dontbeadont',
    			'quality', 'high',
    			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
    			'align', 'middle',
    			'play', 'true',
    			'loop', 'true',
    			'scale', 'showall',
    			'wmode', 'window',
    			'devicefont', 'false',
    			'id', 'dontbeadont',
    			'bgcolor', '#ffffff',
    			'name', 'dontbeadont',
    			'menu', 'true',
    			'allowFullScreen', 'true',
    			'allowScriptAccess','sameDomain',
    			'movie', '/themes/DailyDose/flv/dontbeadont',
    			'salign', ''
    			); //end AC code
    	}
    </script>
    <noscript>
    	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="320" height="280" id="dontbeadont" align="middle">
    	<param name="allowScriptAccess" value="sameDomain" />
    	<param name="allowFullScreen" value="false" />
    	<param name="movie" value="dontbeadont.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	<embed src="dontbeadont.swf" quality="high" bgcolor="#ffffff" width="320" height="280" name="dontbeadont" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
    	</object>
    </noscript>
  </div>
</div>

</body>
</html>

