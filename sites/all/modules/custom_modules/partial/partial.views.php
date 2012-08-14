<?php
// $Id$
/**
 * Partials Module
 */

function partial_views_style_plugins() {
  $viewStyles = partial_db_get_view_styles();
  if (!empty($viewStyles)) {
    foreach ($viewStyles as $viewStyle) {
      $items[$viewStyle->title] = array(
        'name' => t("Partial: $viewStyle->title"),
        'theme' => "partial_views_style",
        'needs_table_header' => TRUE,
        'needs_fields' => TRUE,
        'even_empty' => TRUE,
      );
    }
  }
  return $items;
}

function partial_div_safe($string) {
  $parse = array(" ","--","&");
  return str_replace($parse,"", $string); 
}

function theme_partial_views_style($view, $nodes, $type) {
  if (empty($nodes)) {
    return $view->page_empty;
  } else {
    $typeRef = $type . '_type';
    $partial = partial_db_load_from_title($view->$typeRef);
    if ($partial->view_type == 'grid') {
      $retVal = theme_partial_view_style_grid($view, $nodes, $partial);
    } else {
      $retVal = theme_partial_view_style_list($view, $nodes, $partial);
    }
    return $retVal;    
  }
}

function theme_partial_view_style_list($view, $nodes, $partial) {
  $title = partial_div_safe($view->page_type);
  $retVal = "<div class='views_$title'>";
  foreach ($nodes as $count => $n) {
    $node = node_load($n->nid);
    foreach ($n as $key=>$value) {
      if ($key != 'nid') {
        $node->$key = $value;
      }
    }
    $node->views_index = $count + 1;
    $page = $_GET['page'];
    if ($page > 0) {
      $node->views_index += $page * $view->nodes_per_page;
    }
    $retVal .= partial_render($partial->pid, $node);
  }
  $retVal .= '</div>';
  return $retVal;
}

function theme_partial_view_style_grid($view, $nodes, $partial) {
  
  $title = partial_div_safe($view->name);
  $content = '<table class="view-grid view-grid-' . $view->name . '">';
  if (empty($nodes)) {
    return $view->page_empty;
  }
  // set default count.
  $cols = $partial->view_columns ? $partial->view_columns : 4;

  $percent = 100 / $cols;
  $count = 0;
  $total = count($nodes);
  foreach ($nodes as $count => $n) {
    $node = node_load($n->nid);
    foreach ($n as $key=>$value) {
      if ($key != 'nid') {
        $node->$key = $value;
      }
    }
    if ($count % $cols == 0) { 
      $content .= '<tr>'; 
    }
    $node->count = $count + 1;
    $node->views_index = $count + 1;
    $page = $_GET['page'];
    if ($page > 0) {
      $node->views_index += $page * $view->nodes_per_page;
    }
    $item = partial_render($partial->pid, $node);
    $content .= "<td class='view-grid-item'><div class='view-item view-item-$view->name'>$item</div></td>\n"; 
//    $content .= "<td width='$percent%' class='view-grid-item'><div class='view-item view-item-$view->name'>$item</div></td>\n"; 
    $count++;
    if ($count % $cols == 0) {
      $content .= '</tr>';
    } else if ($count == $total) {
      $extra = $count - (($count % $cols) * $cols);
      $extra = $cols - $extra;
      for ($i = 0; $i < $extra; $i++) {
        $content .= "<td width='$percent%'></td>";
      }
      $content .= '</tr>';
    }
  }
  $content .= '</table>';
  return $content;
}

/*
function partial_views_default_views() {
  $view = new stdClass();
  $view->name = 'components';
  $view->description = t('Listing of partials.');
  $view->access = array ();
  $view->page = TRUE;
  $view->page_title = t('Partials');
  $view->page_header = '';
  $view->page_empty = 'There are no partials in the system.';
  $view->page_header_format = '1';
  $view->page_type = 'table';
  $view->url = 'admin/build/components';
  $view->use_pager = TRUE;
  $view->nodes_per_page = '40';
  $view->sort = array (
    array (
      'tablename' => 'node',
      'field' => 'created',
      'sortorder' => 'ASC',
      'options' => '',
    ),
  );
  $view->field = array (
    array (
      'tablename' => 'node',
      'field' => 'title',
      'label' => t('Title'),
      'handler' => 'views_handler_field_nodelink_with_mark',
    ),
  );
  $view->filter = array ();
  $view->requires = array(node);
  $views[$view->name] = $view;
  return $views;
}
*/
