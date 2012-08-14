<?php
// $Id$
/**
 * Partials Module
 */


//we should change these to variables
function partial_property_menu() {
  return array(
          '#type' => 'select',
          '#options' => menu_get_root_menus(),
        );
}

function partial_property_textfield() {
  return array(
          '#type' => 'textfield',
        );
}

function partial_property_taxonomy() {
  $options_term = array();
  $options_term[0] = '---';
  foreach (taxonomy_get_vocabularies() as $voc) {
    foreach (taxonomy_get_tree($voc->vid) as $tree) {
//      print_r($tree);
      $options_term[$voc->name][$tree->tid] = $tree->name;
    }
  }      
  return array(
    '#type' => 'select',
    '#options' => $options_term,
  );
}

function partial_property_vocabulary() {
  $options_term = array();
  $options_term[0] = '---';
  foreach (taxonomy_get_vocabularies() as $voc) {
    $options_term[$voc->vid] = $voc->name;
  }      
  return array(
    '#type' => 'select',
    '#options' => $options_term,
  );
}

if (module_exists('content')) {
  function partial_property_date_field() {
    $fields = content_fields();
    $options = array();
    if ($fields) {
      foreach ($fields as $key=>$field) {
        if (!strcmp($field['type'], 'datestamp')) {
          $options[$key] = $field['type_name'] . ': ' . $key;
        }
      }
    }
    return array(
      '#type' => 'select',
      '#options' => $options,
    );
  }
}

function partial_property_node() {
  return array(
    '#description' => t('nid or title'),
    '#type' => 'textfield',
    '#maxlength' => 512,
    '#autocomplete_path' => 'partial/node/autocomplete',
  );
}

function partial_property_node_load($partial, $property) {
  if (!empty($partial->properties)) {
    $partialProperty = $partial->properties[$property['name']];
    if (is_numeric($partialProperty['value'])) {
      $node = node_load($partialProperty['value']);
    } else if ($partialProperty['value']) { // by title -- move to db file
      $nid = partial_db_get_nid($partialProperty['value']);
      if ($nid) {
        $node = node_load($nid);
      }
    }
    return $node;
  }
}
