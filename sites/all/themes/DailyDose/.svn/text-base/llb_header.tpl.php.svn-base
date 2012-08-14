<?php # HACK: the two following divs are closed by a special Content-bottom block called "lbb hack to close divs" ?>
<div class="node">
  <div class="content">

<?php
  $city = vitamin_city_current_city();
  $categories = taxonomy_get_tree(11, 0, -1, 1);
  $filename = '/' . path_to_theme() . '/images/lbb/' . strtolower(str_replace(' & ', '_', $category->name)) . '.jpg'
?>
<div id="lbb_top">
  <p class="lbb_heading"><?php print t("Need to get your dog groomed, your stilettos soled, or find the perfect wedding gift for your high-school nemesis? Look no further than our Editor's Little Black book, the go-to-guide to the best shops and services in the city, hand selected from our editor's personal iPhone speed dials. Ready, Set, Shop!") ?></p>
  <div id="lbb_image_ph">   
    <div id="lbb_mainimg"><img src="<?php print $filename ?>" /></div>
    <div id="lbb_categories">
      <h5 class="lbb_cat">
        Choose a category
      </h5>
	  <div class="lbb_cat">
        <?php
          $index = 0;
          foreach ($categories as $mainCategory) {
            $lower = strtolower($mainCategory->name);
            $cap = ucwords($lower);
            $lower = str_replace(' & ', '_', $lower);
            if ($index % 2 == 0) {
              print "<div class='lbb_cat_col'>";
            }
            if ($mainCategory->tid == $category->tid) {
              print "<p><a href='/{$city->field_city_url_path[0]['value']}/lbb/$lower' class='lbb_active'>$cap</a></p>";
            } else {
              print "<p><a href='/{$city->field_city_url_path[0]['value']}/lbb/$lower'>$cap</a></p>"; 
            }
            $index++;
            if ($index % 2 == 0) {
              print "</div>";
            }
          }        
        ?>
      </div>
     </div> 
  </div>
</div>
<div id="lbb_content">
  <h2 class="lbb_section"><?php print ucwords($category->name) ?></h2>
