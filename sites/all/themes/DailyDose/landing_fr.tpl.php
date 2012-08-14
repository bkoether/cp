<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language ?>" xml:lang="<?php print $language ?>">
<head>
  <title>Vitamine du Jour - Le magazine en ligne de la vie moderne au Canada</title>
  <?php print $head; ?>
	<link rel="stylesheet" type="text/css" href="/themes/DailyDose/landing-style.css?v1" />
  <?php print drupal_get_js('footer'); ?>

	<link rel="shortcut icon" href="/themes/DailyDose/favicon.ico" type="image/x-icon" />

  <?php // change sIFR color based on the city
      $sColor = '#' . $city->field_color[0]['value'];
      $sLinkColor = '#' . $city->field_link_color[0]['value'];
      $sBgColor = '#' . $city->field_background_color[0]['value'];
      $sHoverColor = '#' . $city->field_hover_color[0]['value'];
  ?>
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
<body class="<?php print $body_classes; ?>" id="fr">
	

<div id="container">
	<div id="holds-content">
		<div id="main">

			<div id="city_links">
				<div class="title"><span class="do_not_display">SÉLECTIONNEZ UNE ÉDITION:</span></div>
				<a href="/montreal" class="montreal" title="Montreal" ><span class="do_not_display">Montreal</span></a>
				<a href="/montreal_fr" class="montreal-fr" title="Montréal" ><span class="do_not_display">Montréal</span></a>
				<a href="/toronto" class="toronto" title="Toronto"><span class="do_not_display">Toronto</span></a>
				<a href="/calgary" class="calgary" title="Calgary"><span class="do_not_display">Calgary</span></a>
				<a href="/vancouver" class="vancouver" title="Vancouver"><span class="do_not_display">Vancouver</span></a>
			</div>
	
			<div id="header">
				<a href="http://vitamindaily.com" title="English" id="language_switch"><span class="do_not_display">English</span>&nbsp;</a>
				<img src="themes/DailyDose/images/landing-logo_fr.gif" alt="Bienvenue sur le site Vitamine du Jour" />
			</div>
			<div id="intro">
				<p>Félicitations! Vous avez trouvé Vitamine du jour Montréal, le premier guide en ligne du Québec qui vous aide à mordre dans la vie. Abonnez-vous à notre bouchée quotidienne gratuite pour recevoir les conseils les plus savoureux et découvrir des trouvailles inédites dénichées dans votre ville. Vitamine du jour Montréal, c’est exactement le style qu’il vous faut.</p>
				<div id="signup"><a href="/user/register" title="Sign up!">PRENEZ VOTRE DOSE DU JOUR<br />C'EST GRATUIT!</a>	</div>
			</div>
		</div> <!-- #main -->
		<div id="feature_area">
			<div id="search">
                          <!--
				<form id="form" action="/montreal_fr" method="post" accept-charset="UTF-8">
					<input class="box" type="text" name="search_block_form_keys" />
					<input class="button" type="submit" name="op" id="edit-submit" value="Recherche" />
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
				<form action="#" id="dropdown">
  				</form>
                                -->
<?php print drupal_get_form('vitamin_city_landing_search_form', 'fr') ?>                                
			</div>
<?php print vitamin_city_landing_dose('fr') ?>                        
			<div id="feature">
				<a href="/montreal_fr/editors-blog"><img src="/themes/DailyDose/images/editors_promo_fr.jpg" alt="" /></a>
			</div>
		</div>

		<div id="footer">
			<div id="nav_bottom"><a href="/montreal">Montreal</a> / <a href="/montreal_fr">Montr&eacute;al</a> | <a href="/toronto">Toronto</a> | <a href="/calgary">Calgary</a> | <a href="/vancouver">Vancouver</a></div>
			<div id="nav_bottom_sub"><a href="/user/register">S'abonner</a> | <a href="/user">Se désabonner</a> | <a href="/advertise">Annoncer</a> | <a href="/who-we-are">Notre profil</a> | <a href="/contact">Pour nous joindre</a> | <a href="/privacy-policy">Politique de confidentialité</a> | <a href="/terms-of-use">Conditions d'utilisation</a> | <a href="/site-help">Aide</a></div>
			<div id="copyright">&copy; 2008 Daily Dose Media Inc. Tous droits réservés.</div>
      <div id="telefilm">
        <img src="/themes/DailyDose/images/telefilm.png" alt="Telefilm Logo" />
        <p>Produit avec la participation financière de Téléfilm Canada</p>
      </div>
		</div>
	</div> <!-- #holds-content -->
</div> <!-- #container -->
</body>
</html>

