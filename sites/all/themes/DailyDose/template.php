<?php
// $Id: template.php,v 1.12.2.1 2007/01/17 05:28:41 jjeff Exp $

/**
 * @file
 * File which contains theme overrides for the Zen theme.
 */

/*
 * ABOUT
 *
 *  The template.php file is one of the most useful files when creating or modifying Drupal themes.
 *  You can add new regions for block content, modify or override Drupal's theme functions, 
 *  intercept or make additional variables available to your theme, and create custom PHP logic.
 *  For more information, please visit the Theme Developer's Guide on Drupal.org:
 *  http://drupal.org/node/509
 */

 
/*
 * MODIFYING OR CREATING REGIONS
 *
 * Regions are areas in your theme where you can place blocks.
 * The default regions used in themes  are "left sidebar", "right sidebar", "header", and "footer",  although you can create
 * as many regions as you want.  Once declared, they are made available to the page.tpl.php file as a variable.  
 * For instance, use <?php print $header ?> for the placement of the "header" region in page.tpl.php.
 * 
 * By going to  the administer > site building > blocks page you can choose which regions various blocks should be placed.
 * New regions you define here will automatically show up in the drop-down list by their human readable name.
 */
 
 
/*
 * Declare the available regions implemented by this engine.
 *
 * @return
 *    An array of regions.  The first array element will be used as the default region for themes.
 *    Each array element takes the format: variable_name => t('human readable name')
 */
function DailyDose_regions() {
  return array(
       'left' => t('left sidebar'),
       'right' => t('right sidebar'),
       'content_top' => t('content top'),
       'below_title' => t('below title'),
       'content_bottom' => t('content bottom'),
       'header' => t('header'),
       'footer' => t('footer')
  );
} 

/*
 * OVERRIDING THEME FUNCTIONS
 *
 *  The Drupal theme system uses special theme functions to generate HTML output automatically.
 *  Often we wish to customize this HTML output.  To do this, we have to override the theme function.
 *  You have to first find the theme function that generates the output, and then "catch" it and modify it here.
 *  The easiest way to do it is to copy the original function in its entirety and paste it here, changing
 *  the prefix from theme_ to zen_.  For example:
 *
 *   original:  theme_breadcrumb() 
 *   theme override:   zen_breadcrumb()
 *
 *  See the following example. In this theme, we want to change all of the breadcrumb separator links from  >> to ::
 *
 */
function DailyDose_feed_icon($url) {
  if ($image = theme('image', 'themes/DailyDose/images/feed-icon.png', t('Syndicate content'), t('Syndicate content'))) {
    return '<a href="'. check_url($url) .'" class="feed-icon">'. $image. '</a>';
  }
}


 /**
  * Return a themed breadcrumb trail.
  *
  * @param $breadcrumb
  *   An array containing the breadcrumb links.
  * @return a string containing the breadcrumb output.
  */
 function DailyDose_breadcrumb($breadcrumb) {
   if (!empty($breadcrumb)) {
     return '<div class="breadcrumb">'. implode(' :: ', $breadcrumb) .'</div>';
   }
 }
 
 
/* 
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *  The most powerful function available to themers is the _phptemplate_variables() function. It allows you
 *  to pass newly created variables to different template (tpl.php) files in your theme. Or even unset ones you don't want
 *  to use.
 *
 *  It works by switching on the hook, or name of the theme function, such as:
 *    - page
 *    - node
 *    - comment
 *    - block
 *
 * By switching on this hook you can send different variables to page.tpl.php file, node.tpl.php
 * (and any other derivative node template file, like node-forum.tpl.php), comment.tpl.php, and block.tpl.php
 *
 */

 
/**
 * Intercept template variables
 *
 * @param $hook
 *   The name of the theme function being executed
 * @param $vars
 *   A sequential array of variables passed to the theme function.
 */

function _phptemplate_variables($hook, $vars = array()) {
  switch ($hook) {
    // Send a new variable, $logged_in, to page.tpl.php to tell us if the current user is logged in or out.
    case 'page':
      // get the currently logged in user
      global $user;
      
      // An anonymous user has a user id of zero.      
      if ($user->uid > 0) {
        // The user is logged in.
        $vars['logged_in'] = TRUE;
      }
      else {
        // The user has logged out.
        $vars['logged_in'] = FALSE;
      }
      
      $body_classes = array();
      // classes for body element
      // allows advanced theming based on context (home page, node of certain type, etc.)
      $body_classes[] = ($vars['is_front']) ? 'front' : 'not-front';
      $body_classes[] = ($vars['logged_in']) ? 'logged-in' : 'not-logged-in';
      if ($vars['node']->type) {
        $body_classes[] = 'ntype-'. DailyDose_id_safe($vars['node']->type);
      }
      switch (TRUE) {
      	case $vars['sidebar_left'] && $vars['sidebar_right'] :
      		$body_classes[] = 'both-sidebars';
      		break;
      	case $vars['sidebar_left'] :
      		$body_classes[] = 'sidebar-left';
      		break;
      	case $vars['sidebar_right'] :
      		$body_classes[] = 'sidebar-right';
      		break;
      }
      // implode with spaces
      $vars['body_classes'] = implode(' ', $body_classes);
      
      break;
      
    case 'node':
      // get the currently logged in user
      global $user;

      // set a new $is_admin variable
      // this is determined by looking at the currently logged in user and seeing if they are in the role 'admin'
      $vars['is_admin'] = in_array('admin', $user->roles);
      
      $node_classes = array('node');
      if ($vars['sticky']) {
      	$node_classes[] = 'sticky';
      }
      if (!$vars['node']->status) {
      	$node_classes[] = 'node-unpublished';
      }
      $node_classes[] = 'ntype-'. DailyDose_id_safe($vars['node']->type);
      // implode with spaces
      $vars['node_classes'] = implode(' ', $node_classes);
      
      break;
      
    case 'comment':
      // we load the node object that the current comment is attached to
      $node = node_load($vars['comment']->nid);
      // if the author of this comment is equal to the author of the node, we set a variable
      // then in our theme we can theme this comment differently to stand out
      $vars['author_comment'] = $vars['comment']->uid == $node->uid ? TRUE : FALSE;
      break;
  }
  
  return $vars;
}

/**
* Converts a string to a suitable html ID attribute.
* - Preceeds initial numeric with 'n' character.
* - Replaces space and underscore with dash.
* - Converts entire string to lowercase.
* - Works for classes too!
* 
* @param string $string
*  the string
* @return
*  the converted string
*/
function DailyDose_id_safe($string) {
  if (is_numeric($string{0})) {
    // if the first character is numeric, add 'n' in front
    $string = 'n'. $string;
  }
  return strtolower(preg_replace('/[^a-zA-Z0-9-]+/', '-', $string));
}

/**
 * View: Home
 */
function phptemplate_views_view_list_dose($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}

function phptemplate_views_view_list_taxonomy_term($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}

/**
 * View: New Multi-city Taxonomy
 */
function phptemplate_views_view_list_Taxonomy($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}

/**
 * View: Taxonomy_Vancouver
 */
//function phptemplate_views_view_list_Taxonomy_Vancouver($view, $nodes, $type) {
//  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
//}

/**
 * View: Taxonomy_Montreal
 */
//function phptemplate_views_view_list_Taxonomy_Montreal($view, $nodes, $type) {
//  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
//}

/**
 * View: Taxonomy_Toronto
 */
//function phptemplate_views_view_list_Taxonomy_Toronto($view, $nodes, $type) {
//  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
//}

/**
 * View: Vitamin_M
 */
/* these functions are no longer needed - Haig Sept 5


function phptemplate_views_view_list_Vitamin_M($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Montreal_health($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Montreal_fashion($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Montreal_home($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Montreal_Arts($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Montreal_Travel($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Montreal_dining($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Montreal_moms($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
*/

/**
 * View: Vitamin_T
 */
/* these functions are no longer needed - Haig Sept 5

function phptemplate_views_view_list_Vitamin_T($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Toronto_health($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Toronto_fashion($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Toronto_home($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Toronto_Arts($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Toronto_Travel($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Toronto_dining($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Toronto_moms($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}*/



/**
 * View: Vitamin_V
 */
/* these functions are no longer needed - Haig Sept 5

function phptemplate_views_view_list_Vancouver_health($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Vancouver_fashion($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Vancouver_home($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Vancouver_Arts($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Vancouver_Travel($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Vancouver_dining($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}
function phptemplate_views_view_list_Vancouver_moms($view, $nodes, $type) {
  return phptemplate_views_view_list_Vitamin_V($view, $nodes, $type);
}*/

function phptemplate_views_view_list_Vitamin_V($view, $nodes, $type) {
  $fields = _views_get_fields();

  $taken = array();

  // Set up the fields in nicely named chunks.
  foreach ($view->field as $id => $field) {
    $field_name = $field['field'];
    if (isset($taken[$field_name])) {
      $field_name = $field['queryname'];
    }
    $taken[$field_name] = true;
    $field_names[$id] = $field_name;
  }

  // Set up some variables that won't change.
  $base_vars = array(
    'view' => $view,
    'view_type' => $type,
  );

  $ad = 1;
  foreach ($nodes as $i => $node) {
    $vars = $base_vars;
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';

    $vars['ad'] = ($ad == 1)? TRUE : FALSE;
    $ad = 0;

    foreach ($view->field as $id => $field) {
      $name = $field_names[$id];
      $vars[$name] = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      if (isset($field['label'])) {
        $vars[$name . '_label'] = $field['label'];
      }
    }
    $items[] = _phptemplate_callback('views-list-Vitamin', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}

/**
 * views template to output a view.
 * This code was generated by the views theming wizard
 * Date: Fri, 08/24/2007 - 11:14
 * View: Top10_vancouver_1
 *
 * This function goes in your template.php file
 */
function phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type) {
  $fields = _views_get_fields();

  $taken = array();

  // Set up the fields in nicely named chunks.
  foreach ($view->field as $id => $field) {
    $field_name = $field['field'];
    if (isset($taken[$field_name])) {
      $field_name = $field['queryname'];
    }
    $taken[$field_name] = true;
    $field_names[$id] = $field_name;
  }

  // Set up some variables that won't change.
  $base_vars = array(
    'view' => $view,
    'view_type' => $type,
  );

  foreach ($nodes as $i => $node) {
    $vars = $base_vars;
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';
    foreach ($view->field as $id => $field) {
      $name = $field_names[$id];
      $vars[$name] = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      if (isset($field['label'])) {
        $vars[$name . '_label'] = $field['label'];
      }
    }
    $items[] = _phptemplate_callback('views-list-Top10', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}
/**
function phptemplate_views_view_list_Top10_vancouver_2($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_vancouver_3($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_vancouver_4($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_vancouver_5($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_vancouver_6($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_vancouver_7($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_vancouver_8($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_vancouver_9($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_vancouver_10($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_toronto_1($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_toronto_2($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_toronto_3($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_toronto_4($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_toronto_5($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_toronto_6($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_toronto_7($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_toronto_8($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_toronto_9($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_toronto_10($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}

function phptemplate_views_view_list_Top10_montreal_1($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_montreal_2($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_montreal_3($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_montreal_4($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_montreal_5($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_montreal_6($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_montreal_7($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_montreal_8($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_montreal_9($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
function phptemplate_views_view_list_Top10_montreal_10($view, $nodes, $type) {
  return phptemplate_views_view_list_Top10_vancouver_1($view, $nodes, $type);
}
 */

function phptemplate_dd_archive_node($node, $dateday) {
  // Get category
  foreach($node->taxonomy as $cats) {
    if($cats->vid == 3) {
      $cat = ucwords(strtolower($cats->name));
      break;
    }
  }
  $output = '<dt>'. $dateday .'</dt>';
  $output .= '<dd class="archive_day_category">'. $cat .'</dd>';
  $output .= '<dd class="archive_day_title">'. l($node->title, 'node/'. $node->nid) .'</dd>';
  $output .= '<dd class="archive_day_annotation">'. $node->field_annotations[0]['value'] .'</dd>';
  return $output;
}

function phptemplate_dd_archive_page($city, $type, $date, $entries) {
  $type = ($type != '') ? $type : 'all';
  $years = _dd_archive_make_years($date);
  $months = _dd_archive_month_as_text($date);
  $cats = _dd_archive_categories();

  $output  = '<div id="archive-container">';
  $output  .= '<p>BROWSE BY CATEGORY:</p><ul id="archive-categories">';

  $arg3 = '/'. $date->year;
  $arg4 = '/'. $date->month;

  if($type == 'all') {
    $output .= '<li class="active">SHOW ALL</li>';
  }
  else {
    $output .= '<li>'. l('SHOW ALL', $city->field_city_url_path[0]['value'] . '/archive/all' . $arg3 . $arg4 ) .'</li>';
  }

  foreach($cats as $k => $v) {
    if($type == $k) {
      $output .= '<li class="active">'. $v .'</li>';
    }
    else {
      $output .= '<li>'. l($v, $city->field_city_url_path[0]['value'] . '/archive/'. $k . $arg3 . $arg4 ) .'</li>';
    }
  }
  $output  .= '</ul>';
  $output .= '<ul class="archive_year">';

  foreach($years as $y) {
    if($y > $date->year) {
      $output .= '<li>' . l($y, $city->field_city_url_path[0]['value'] . '/archive/'. $type .'/'. $y) . '</li>';
    }
    elseif($y == $date->year) {
      $output .= '<li class="active"><p>'. $date->year .'</p>';
      break;
    }
  }

  $output .= '<ul class="archive_month">';

  krsort($months);
  foreach($months as $k => $month) {
    $url_year = arg(3);
    $url_month = arg(4);

    // /archive
    if(!arg(2)) {
      $url_year = date('Y');
      $url_month = date('n');
    }
    // /archive/all
    elseif(arg(2) && !arg(3)) {
      drupal_goto($city->field_city_url_path[0]['value'] . '/archive');
    }
    // /archive/all/year
    elseif(arg(3) && !arg(4)) {
      $output .= '<li>' . l($month, $city->field_city_url_path[0]['value'] . '/archive/'. $type .'/'. $date->year .'/'. $k);
      // impossible value - avoids duplicate print of each month due to condition below
      $url_month = 13;
    }

    if($k == $url_month) {
      $output .= '<li class="active"><p>'. $month .'</p>';
      $output .= '<dl class="archive_day">';
      krsort($entries);
      foreach($entries as $entry) {
        $output .= $entry;
      }
      $output .= '</dl></li>';
      break;
    }
    elseif($k > $url_month) {
      $output .= '<li>' . l($month, $city->field_city_url_path[0]['value'] . '/archive/'. $type .'/'. $date->year .'/'. $k);
    }
  }

  foreach($months as $k => $month){
    if($k < $date->month) {
      $output .= '<li>' . l($month, $city->field_city_url_path[0]['value'] . '/archive/'. $type .'/'. $date->year .'/'. $k) . '</li>';
    }
  }
  $output .= '</ul></li>';

  foreach($years as $y) {
    if($y < $date->year) {
      $output .= '<li>' . l($y, $city->field_city_url_path[0]['value'] . '/archive/'. $type .'/'. $y) . '</li>';
    }
  }
  $output .= "</ul></div>";
  return $output;
}


/* This function is here to prevent the ad fields on city from having the tinymce editor
 * as per:
 *  http://elrems.wordpress.com/2008/08/22/how-to-disable-tinymce-per-fields-in-drupal-avocado-shake-dot-net/
*/
function DailyDose_tinymce_theme($init, $textarea_name, $theme_name, $is_running) {
  switch ($textarea_name) {
    // Disable tinymce for these textareas
    case 'log': // book and page log
    case 'img_assist_pages':
    case 'caption': // signature
    case 'pages':
    case 'access_pages': //TinyMCE profile settings.
    case 'user_mail_welcome_body': // user config settings
    case 'user_mail_approval_body': // user config settings
    case 'user_mail_pass_body': // user config settings
    case 'synonyms': // taxonomy terms
    case 'description': // taxonomy terms
		case 'webform-confirmation':        //webform confirmation (it's breaking it)
		case 'webform-additional-validate': //same
		case 'webform-additional-submit':   //same
		case 'extra-description':					  //same
		case 'value':												//same
		case 'extra-options':								//same
		case 'extra-questions':							//same
		case 'submitted-your-answer':
      unset($init);
      break;
    case 'field-ad-top-160x600-home-0-value': // ad field doesn't need tinymce
      unset($init);
      break;
    case 'field-ad-top-160x600-ros-0-value': // ad field doesn't need tinymce
      unset($init);
      break;
    case 'field-ad-middle-160x600-0-value': // ad field doesn't need tinymce
      unset($init);
      break;
    case 'field-ad-inline-300x250-home-0-value': // ad field doesn't need tinymce
      unset($init);
      break;
    case 'field-ad-inline-300x250-ros-0-value': // ad field doesn't need tinymce
      unset($init);
      break;
    case 'field-ad-newsletter-160x600-0-value': // ad field doesn't need tinymce
      unset($init);
      break;

    // Force the 'simple' theme for some of the smaller textareas.
    case 'signature':
    case 'site_mission':
    case 'site_footer':
    case 'site_offline_message':
    case 'page_help':
    case 'user_registration_help':
    case 'user_picture_guidelines':
      $init['theme'] = 'simple';
      foreach ($init as $k => $v) {
        if (strstr($k, 'theme_advanced_')) unset($init[$k]);
      }
      break;
  }

	/**
	 * views template to output a view.
	 * This code was generated by the views theming wizard
	 * Date: Fri, 09/25/2009 - 10:29
	 * View: global_search
	 *
	 * This function goes in your template.php file
	 */
  // function phptemplate_views_view_list_global_search($view, $nodes, $type) {
  //   $fields = _views_get_fields();
  // 
  //   $taken = array();
  // 
  //   // Set up the fields in nicely named chunks.
  //   foreach ($view->field as $id => $field) {
  //     $field_name = $field['field'];
  //     if (isset($taken[$field_name])) {
  //       $field_name = $field['queryname'];
  //     }
  //     $taken[$field_name] = true;
  //     $field_names[$id] = $field_name;
  //   }
  // 
  //   // Set up some variables that won't change.
  //   $base_vars = array(
  //     'view' => $view,
  //     'view_type' => $type,
  //   );
  // 
  //   foreach ($nodes as $i => $node) {
  //     $vars = $base_vars;
  //     $vars['node'] = $node;
  //     $vars['count'] = $i;
  //     $vars['stripe'] = $i % 2 ? 'even' : 'odd';
  //     foreach ($view->field as $id => $field) {
  //       $name = $field_names[$id];
  //       $vars[$name] = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
  //       if (isset($field['label'])) {
  //         $vars[$name . '_label'] = $field['label'];
  //       }
  //     }
  //     $items[] = _phptemplate_callback('views-list-global_search', $vars);
  //   }
  //   if ($items) {
  //     return theme('item_list', $items);
  //   }
  // }

  /* Example, add some extra features when using the advanced theme.
  
  // If $init is available, we can extend it
  if (isset($init)) {
    switch ($theme_name) {
     case 'advanced':
       $init['extended_valid_elements'] = array('a[href|target|name|title|onclick]');
       break;
    }
  }
  
  */

  // Always return $init
  return $init;
}



/**
 *	Adding a javascript file to the theme
 **/

drupal_add_js(drupal_get_path('theme', 'DailyDose') .'/scripts.js', 'theme');


/**
 *  rogers ad generator
 *  @param $type
 *  the type of ad (leader, bigbox, skyscraper, adHook)
 *  @param $cityid
 *  the cityid ($city->nid)
 *  @param $not_home
 *   boolean if it's the homepage (arg(1))
 **/

function DailyDose_rogersAd($type, $cityid, $not_home){

  $output="";
  $size = array('leader' => '728, 90', 'bigbox' => '300, 250', 'skyscraper' => '160, 600', '1x1', '1, 1' );
  $cityname = array(3332 => 'montreal', 3333 => 'montreal', 3496 => 'calgary', 3331 => 'toronto', 3332 => 'montreal', 3330 => 'vancouver');
  $homepage = (!$not_home) ? '/homepage' : '';

  //3333 is the french one
  if($cityid == 3333){

    $output .= "<script type='text/javascript' src='http://www.googletagservices.com/tag/js/gpt.js'>";
    $output .= "googletag.defineSlot('/7326/VitaminDaily.network/VitaminDailyFR.adNetwork/" . $cityname[$cityid] . $homepage . "',[" . $size[$type] . "], 'rogers_VitaminDaily.network_" . $type . "').addService(googletag.pubads());";
    $output .= "googletag.pubads().enableSyncRendering();";
    $output .= "googletag.enableServices();";
    $output .= "googletag.display('rogers_VitaminDaily.network_" . $type . "');";
    $output .= "</script>";

  }else{

    $output .= "<script type='text/javascript' src='http://www.googletagservices.com/tag/js/gpt.js'>";
    $output .= "googletag.defineSlot('/7326/VitaminDaily.network/VitaminDaily.adNetwork/" . $cityname[$cityid] . $homepage . "',[" . $size[$type] . "], 'rogers_VitaminDaily.network_" . $type . "').addService(googletag.pubads());";
    $output .= "googletag.pubads().enableSyncRendering();";
    $output .= "googletag.enableServices();";
    $output .= "googletag.display('rogers_VitaminDaily.network_" . $type . "');";
    $output .= "</script>";

  }

  return $output;
}



