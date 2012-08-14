<?php
// $Id$
/**
 * Partials Module
 */

function partial_hidden_properties() {
  foreach ($_POST as $key=>$value) {
    if (strstr($key, 'hproperty_')) {
      $temp = string_to_array($value);
      $properties[$temp['name']] = $temp;
    }
  }
  return $properties;
}

  /*
function partial_prepare(&$node) {
  if ($_POST['new_property']) {
    $property = array('name'=>$_POST['property_name'], 'label'=>$_POST['property_label'], 'type'=>$_POST['property_type'], 'attributes'=>$_POST['property_attributes']);
    $node->properties[$property['name']] = $property; 
    unset($_POST['property_name'], $_POST['property_label'], $_POST['property_type'], $_POST['property_attributes']);
  } else if ($node->partial_file) {
    foreach ($GLOBALS['partial_files'] as $partialFile) {
      if ($_POST[$partialFile->getLoadButton()]) {
        $fullPath = path_to_theme() . '/' . $node->partial_file . $partialFile->getExtension();
        $fileArray = file($fullPath);
        $partialFile->setFileValue($node, implode($fileArray));
        $partialFile->setUseValue($node, true);
        $_POST[$partialFile->getFileField()] = $partialFile->getFileValue($node);
        $_REQUEST[$partialFile->getFileField()] = $partialFile->getFileValue($node); // why must we seem to have to do this?
        $_POST[$partialFile->getUseField()] = true;
      } else if ($_POST[$partialFile->getSaveButton()]) {
        $fullPath = path_to_theme() . '/' . $node->partial_file . $partialFile->getExtension();
        if (!$handle = fopen($fullPath, 'w')) {
          drupal_set_message('Error opening file ' . $fullPath);
          return;
        }
        $partialFile->setFileValue($node, $_REQUEST[$partialFile->getFileField()]);
        $_POST[$partialFile->getUseField()] = false;
        fwrite($handle, $partialFile->getFileValue($node));
        fclose($handle);
      }
    }
  }
}
  */

function partial_handle_files_submit(&$partial) {
  
  if ($partial->partial_file) {
    foreach (partial_files() as $partialFile) {
      if ($_POST[$partialFile->getLoadButton()]) {
        $fullPath = $partialFile->getFullPath($partial);
        $fileArray = file($fullPath);
        $partialFile->setFileValue($partial, implode($fileArray));
        $partialFile->setUseValue($partial, true);
        $_POST[$partialFile->getFileField()] = $partialFile->getFileValue($partial);
        $_REQUEST[$partialFile->getFileField()] = $partialFile->getFileValue($partial); // why must we seem to have to do this?
        $_POST[$partialFile->getUseField()] = true;
      } else if ($_POST[$partialFile->getSaveButton()]) {
        $dirPath = $_SERVER['DOCUMENT_ROOT'] . $partialFile->getDirPath($partial);
        if (!is_dir($dirPath)) {
          mkdir($dirPath);
        }
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . $partialFile->getFullPath($partial);
        if (!$handle = fopen($fullPath, 'w')) {
          drupal_set_message('Error opening file ' . $fullPath);
          return;
        }
        $partialFile->setFileValue($partial, $_REQUEST[$partialFile->getFileField()]);
        $useField = $partialFile->getUseField();
        $partial->$useField = false;
//        $_POST[$partialFile->getUseField()] = false;
        fwrite($handle, $partialFile->getFileValue($partial));
        fclose($handle);
      }
    }
  }
  
  
  //i shouldn't need this.. very confusing!
 // $node->internal_template = $_REQUEST['internal_template'];
 // $node->internal_js = $_REQUEST['internal_js'];
 // $node->internal_php = $_REQUEST['internal_php'];
 // $node->internal_css = $_REQUEST['internal_css'];
  
}

function partial_validate(&$partial) {
  if ($_POST['op'] != 'Cancel') {
    if (empty($partial->title)) {
      if (empty($partial->partial_file)) {
        form_set_error('title', t('The partial needs a name or file.'));
      }
    }
  } else if ($_POST['op'] == 'New Property') {
    if (empty($partial->property_name)) {
      form_set_error('property_name', t('You need a property name.'));
    }
    if (empty($partial->property_type)) {
      form_set_error('property_type', t('You need a property type.'));
    }
  }
}

function partial_form_submit($form_id, &$form_values) {
  if ($form_values['op'] == 'Cancel') {
//    if ($form_values['pid']) {
//      return PATH_PREFIX . $form_values['pid'];      
//    } else {
      return PARTIAL_ADMIN_PATH;
//    }
  } else {
    $partial = arr2obj($form_values);
    partial_handle_files_submit($partial);
    foreach (partial_files() as $partialFile) {  //not sure why these values don't end up in form_value?
      $key = $partialFile->getFileField();
      $partial->$key = $_POST[$key];
    }
    
    $partial->properties = partial_hidden_properties();
    if (!empty($partial->properties)) {
      foreach ($partial->properties as $property) {
        $name = $property['name'];
        if ($_POST['property_remove_'.$name]) {
          $anchor = '#properties';
          unset($partial->properties[$name]);
        } else if ($_POST['property_'.$name]) {
          $partial->properties[$name]['value'] = $_POST['property_'.$name];
        } else if ($_POST['ns_property_attributes_'.$name]) {
          $attributes = $_POST['ns_property_attributes_'.$name];
          $partial->properties[$name]['attributes'] = $attributes;
        }
      }
    }
    
    if (empty($partial->title)) {
      if ($partial->partial_file) {
        $partial->title = $partial->partial_file;
      }
    }
    if ($form_values['op'] == $form_values['new_property']) {
      $anchor = '#properties';
      $property = array(
                          'name'=>$form_values['property_name'],
                          'label'=>$form_values['property_label'],
                          'type'=>$form_values['property_type'],
                          'attributes'=>$form_values['property_attributes']
                        );
      
      $partial->properties[$property['name']] = $property; 
      unset($form_values['property_name'], $form_values['property_label'], $form_values['property_type'], $form_values['property_attributes']);
    }
    if ($partial->pid) {
      partial_db_update($partial);
      module_invoke_all('partial_update', $partial);
      //watchdog('content', t('@type: updated %title.', array('@type' => t($node->type), '%title' => $node->title)), WATCHDOG_NOTICE, l(t('view'), 'node/'. $node->nid));
      //drupal_set_message(t('The %post has been updated.', array('%post' => node_get_types('name', $node))));
    }
    else {
      partial_db_insert($partial);
      module_invoke_all('partial_insert', $partial);

//      watchdog('content', t('@type: added %title.', array('@type' => t($node->type), '%title' => $node->title)), WATCHDOG_NOTICE, l(t('view'), "node/$node->nid"));
//      drupal_set_message(t('Your %post has been created.', array('%post' => node_get_types('name', $node))));
    }
    partial_db_clear_cache();

    if ($partial->pid) {
      if ($form_values['op'] == 'Save') {
        return PARTIAL_ADMIN_PATH;
//        return PATH_PREFIX . $partial->pid;
      } else { // if ($form_values['op'] == 'Save and edit') {
        $retVal =  PARTIAL_PATH_PREFIX . $partial->pid . '/edit';
        if ($anchor) {
//          $retVal .= '/' . $anchor;
        }
        return $retVal;
      }
    }
  }
}

function partial_form($partial=null, $clone=false) {
  if ($clone) {
    $partial->pid = null;
  }
  drupal_set_breadcrumb(partial_breadcrumb());  
  $modulePath = drupal_get_path('module', 'partial');
  drupal_add_css($modulePath . '/partial.css');
  drupal_add_js($modulePath . '/partial.js');
  
//  $type = node_get_types('type', $node);
//  $properties = partial_load_variable_defs($node->partial_file);
  
//  $form['tabset'] = array(
//    '#type' => 'tabset',
//  );
  
  //info tab
  $form['tabInfo'] = array(
    '#type' => 'fieldset',
    '#title' => t('Info'),
    '#collapsible' => true,
  );
  $form['tabInfo']['title'] = array(
    '#type' => 'textfield',
    '#title' => check_plain('Title'),
    '#required' => FALSE,
    '#default_value' => $partial->title,
    '#weight' => -10
  );
/*
  $form['tabset']['tabInfo']['theme'] = array(
      '#type' => 'checkbox',
      '#title' => t('Use for current theme only.'),
      '#default_value' => (bool)$node->theme,
      '#weight' => -9
	);
*/  
  $form['tabInfo']['file'] = partial_fileinfo_edit_form($partial);
  $form['tabInfo']['file']['#weight'] = -8;

  if (!empty($partial->properties)) {
    $form['tabInfo']['properties'] = partial_properties_edit_form($partial);
    $form['tabInfo']['properties']['#weight'] = -7;
  }
  
  $form['tabInfo']['function'] = partial_function_edit_form($partial);
  $form['tabInfo']['function']['#weight'] = -6;
  
	//metadata
//  $form['tabset']['tabInfo']['metadata'] = partial_metadata_edit_form($node);
//  $form['tabset']['tabInfo']['metadata']['#weight'] = -5;
  
  //file tabs
  foreach (partial_files() as $partialFile) {
    $form[$partialFile->getKey()] = partial_file_edit_form($partialFile, $partial);
  }
  
  $form['propertyDefs'] = partial_property_defs_edit_form($partial);
  
  if ($partial->pid) {
    $form['pid'] = array(
      '#type' => 'hidden',
      '#value' => $partial->pid,
    );
  }
  $form['save'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
  );  
  $form['save_and_edit'] = array(
    '#type' => 'submit',
    '#value' => t('Save and edit'),
  );  
  $form['cancel'] = array(
    '#type' => 'submit',
    '#value' => t('Cancel'),
  );  
  return $form;
}

function array_to_string($array) {
  if (!empty($array)) {
    foreach ($array as $key=>$value) {
      $retVal .= $key . '=' . $value . ',';
    }
  }
  return $retVal;
}

function string_to_array($string) {
  if ($string) {
    $pairs = explode(',', $string);
    if (!empty($pairs)) {
      foreach ($pairs as $value) {
        $actuals = explode('=', $value);
        $retVal[$actuals[0]] = $actuals[1];
      }
    }
  }
  return $retVal;
}

function partial_property_defs_edit_form($partial) {
  $form = array(
    '#type' => 'fieldset',
    '#title' => t('Properties'),
    '#collapsible' => true,
    '#collapsed' => empty($partial->properties),
  );
  $form['anchor'] = array(
    '#value' => "<a name='properties'></a>",
  );
  $form['properties'] = array(
    '#type' => 'partial_properties',
    '#value' => $partial->properties,
    '#weight' => -8
  );
  if ($partial->properties) {
    foreach($partial->properties as $property) {
      $form['properties']['property_remove_'.$property['name']] = array(
                                                               '#type'=>'submit',
                                                               '#name'=>'property_remove_'.$property['name'],
                                                               '#value'=>t('Remove')
                                                               );
      $form['hproperty_' . $property['name']] = array(
        '#type' => 'hidden',
        '#value' => array_to_string($property),
      );
    }
  }
  $form['property_name'] = array(
    '#type' => 'textfield',
    '#title' => t('Name'),
    '#weight' => -6,
    '#size' => 40,
  );
  $form['property_label'] = array(
    '#type' => 'textfield',
    '#title' => t('Label'),
    '#weight' => -4,
    '#size' => 40,
  );
  $form['property_type'] = array(
    '#type' => 'select',
    '#title' => t('Type'),
    '#weight' => -2,
    '#options' => partial_property_types(),
  );
  $form['property_attributes'] = array(
    '#type' => 'textarea',
    '#title' => t('Attributes'),
    '#rows' => 3,
    '#weight' => -0,
  );
  $form['new_property'] = array(
        '#type' => 'submit',
        '#name' => 'op',
        '#value' => t('New Property'),
        '#weight' => 4,
  );  
  return $form;
}

function theme_partial_properties($element) {
  $header = array(t('Name'), t('Label'), t('Type'), t('Attributes'), null);
  if (!empty($element['#value'])) {
    $property_types = partial_property_types();
    foreach ($element['#value'] as $property) {
      $type = $property_types[$property['type']];
      $rows[] = array($property['name'],
                      $property['label'],
                      $type,
                      $property['attributes'],
                      theme('submit', $element['property_remove_'.$property['name']]),
                      );
    }
  }
  $output = theme('table', $header, $rows);
  return $output;
}

function partial_fileinfo_edit_form($partial) {
  $form = array(
    '#type' => 'fieldset',
    '#title' => t('File'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );
  $prefix = 'partials/';
  if ($partial->use_folder && !empty($partial->partial_file)) {
    $prefix .= $partial->partial_file . '/';
  }
  if ($partial->node_prefix) {
    $prefix .= '{nodetype}-';
  }
  $form['partial_file'] = array(
    '#type' => 'textfield',
    //'#title' => ,
    '#required' => FALSE,
		'#size' => 20,
		'#field_prefix' => $prefix,
		'#field_suffix' => ".tpl.php",
		'#maxlength' => 80,
		'#default_value' => $partial->partial_file,
    '#weight' => -8
  );
  $form['use_folder'] = array(
      '#type' => 'checkbox',
      '#title' => t('Use separate folder.'),
      '#default_value' => $partial->use_folder,
      '#weight' => -7
	);
  $form['node_prefix'] = array(
      '#type' => 'checkbox',
      '#title' => t('Use the type of the context node as file prefix.'),
      '#default_value' => $partial->node_prefix,
      '#weight' => -6
	);
  return $form;
}

//from info tab
function partial_properties_edit_form($partial) {
  $form = array(
    '#type' => 'fieldset',
    '#title' => t('Properties'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  foreach ($partial->properties as $key=>$value) {
    $functionName = 'partial_property_' . $value['type'];
    $index = 'property_'.$key;
    $form[$index] = call_user_func($functionName);
    $label = $value['label']?$value['label']:$value['name'];
    $form[$index]['#title'] = $label;
    $form[$index]['#property_type'] = $value['type'];
    
    
    
//    if ($node->properties) {
      $form[$index]['#default_value'] = $value['value'];
//    }
  }
  return $form;
}

function partial_function_edit_form($partial) {
  $form = array(
    '#type' => 'fieldset',
    '#title' => t('Function'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );

	$form['page'] = partial_page_edit_form($partial);
  $form['page']['#weight'] = -6;

	$form['simple_page'] = partial_simple_page_edit_form($partial);
  $form['simple_page']['#weight'] = -5;

	$form['block'] = partial_block_edit_form($partial);
  $form['block']['#weight'] = -4;
  
  if (module_exists('views')) {
    $form['views'] = partial_views_edit_form($partial);
    $form['views']['#weight'] = -3;
  }
  return $form;
}

function partial_block_edit_form($partial) {
	$form = array(
		'#type' => 'fieldset',
		'#title' => t('Block'),
		'#collapsible' => TRUE,
		'#collapsed' => empty($partial->provide_block),
	);
  $form['provide_block'] = array(
      '#type' => 'checkbox',
      '#title' => t('Provide Block.'),
      '#default_value' => $partial->provide_block,
	);
  $form['block_title'] = array(
    '#type' => 'textfield',
    '#title' => 'Title',
    '#required' => FALSE,
    '#default_value' => $partial->block_title,
  );
  return $form;
}

function partial_views_edit_form($partial) {  
	$form = array(
		'#type' => 'fieldset',
		'#title' => t('Views'),
		'#collapsible' => TRUE,
		'#collapsed' => empty($partial->provide_view_style),
	);
  $form['provide_view_style'] = array(
    '#type' => 'checkbox',
    '#title' => t('Provide View.'),
    '#default_value' => $partial->provide_view_style,
    '#weight' => -10,
	);
  $form['view_type'] = array(
    '#type' => 'select',
    '#title' => t('View Layout'),
    '#default_value' => $partial->view_type?$partial->view_type:'list',
    '#options' => array(
        'list' => t('List'),
        'grid' => t('Grid'),
      ),
    '#weight' => 0,
	);
  $form['view_columns'] = array(
    '#type' => 'textfield',
    '#title' => 'Grid Columns',
    '#size' => 2,
    '#maxlength' => 2,
    '#required' => FALSE,
    '#default_value' => $partial->view_columns,
    '#weight' => 3,
  );
  return $form;
}

function partial_page_edit_form($partial) {
	$form = array(
		'#type' => 'fieldset',
		'#title' => t('Page'),
		'#collapsible' => TRUE,
		'#collapsed' => empty($partial->provide_page),
	);
  $form['provide_page'] = array(
      '#type' => 'checkbox',
      '#title' => t('Provide Page.'),
      '#default_value' => $partial->provide_page,
	);
  $form['page_url'] = array(
    '#type' => 'textfield',
    '#title' => 'URL',
    '#required' => FALSE,
    '#default_value' => $partial->page_url,
  );
  $form['page_title'] = array(
    '#type' => 'textfield',
    '#title' => 'Title',
    '#required' => FALSE,
    '#default_value' => $partial->page_title,
  );
  return $form;
}

function partial_simple_page_edit_form($partial) {
	$form = array(
		'#type' => 'fieldset',
		'#title' => t('Simple Page'),
		'#collapsible' => TRUE,
		'#collapsed' => empty($partial->provide_simple_page),
	);
  $form['provide_simple_page'] = array(
      '#type' => 'checkbox',
      '#title' => t('Provide Simple Page.'),
      '#default_value' => $partial->provide_simple_page,
	);
  $form['simple_page_url'] = array(
    '#type' => 'textfield',
    '#title' => 'URL',
    '#required' => FALSE,
    '#default_value' => $partial->simple_page_url,
  );
  $form['simple_page_title'] = array(
    '#type' => 'textfield',
    '#title' => 'Title',
    '#required' => FALSE,
    '#default_value' => $partial->simple_page_title,
  );
  return $form;
}

function partial_metadata_edit_form($partial) {
  $form = array(
    '#type' => 'fieldset',
    '#title' => t('Meta data'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['partial_description'] = array(
		'#type' => 'textarea',
		'#title' => t('Description'),
		'#default_value' => $partial->partial_description,
  );
  return $form;
}

function partial_file_edit_form($partialFile, $partial) {
  $collapsed = !$partialFile->getUseValue($partial);
  if ($collapsed) $collapsed = !$partialFile->hasPhysicalFile($partial);
//  $path = base_path() . drupal_get_path('module', 'partial') . '/css.gif';
//  $hook = "<img src='$path'/>" . $fileLabel;
  $form = array(
    '#type' => 'fieldset',
    '#title' => t($partialFile->getLabel()),
    '#collapsible' => TRUE,
    '#collapsed' => $collapsed,
  );
//  if (!$partialFile->getUseValue($partial)) {
    $prefix = 'partials/';
    if ($partial->use_folder && !empty($partial->partial_file)) {
      $prefix .= $partial->partial_file . '/';
    }
    if ($partial->node_prefix) {
      $prefix .= '{nodetype}-';
    }
    if ($partialFile->hasPhysicalFile($partial)) {
      $fileLabel = $prefix . $partial->partial_file . $partialFile->getExtension();
    } else {
      $fileLabel = "<span class='partialFileNotFound'>" . $prefix . $partial->partial_file . $partialFile->getExtension() . '</span>';
    }
    $fileLabel = 'File: ' . $fileLabel;
    $form['file_info'] = array(
      '#type' => 'item',
//      '#title' => t('File'),
      '#value' => $fileLabel,
      '#weight' => -9,
    );
//  }
  if ($partialFile->allowInternal) {
    $form[$partialFile->getUseField()] = array(
        '#type' => 'checkbox',
        '#title' => t('Use internal data'),
        '#default_value' => $partialFile->getUseValue($partial),
        '#weight' => -7,
    );
    $form[$partialFile->getLoadButton()] = array(
          '#type' => 'submit',
          '#value' => t('Load from file'),
          '#name' => $partialFile->getLoadButton(),
          '#tree' => FALSE,
          '#weight' => -5,
    );  
    $form[$partialFile->getSaveButton()] = array(
          '#type' => 'submit',
          '#value' => t('Save to file'),
          '#name' => $partialFile->getSaveButton(),
          '#tree' => FALSE,
          '#weight' => -4,
    );  
    $form[$partialFile->getFileField()] = array(
      '#type' => 'textarea',
      '#rows' => 10,
      '#value' => $partialFile->getFileValue($partial),
      '#required' => FALSE
    );
    if ($partialFile->getUseValue($partial)) {
      $form[$partialFile->getUseField()]['#weight'] = -7;
      $form[$partialFile->getLoadButton()]['#weight'] = -5;
      $form[$partialFile->getSaveButton()]['#weight'] = -3;
      $form[$partialFile->getFileField()]['#weight'] = -1;
    } else {
      $form[$partialFile->getUseField()]['#weight'] = 1;
      $form[$partialFile->getLoadButton()]['#weight'] = 3;
      $form[$partialFile->getSaveButton()]['#weight'] = 5;
      $form[$partialFile->getFileField()]['#weight'] = 7;
    }
  }
  if (module_exists('codefilter')) {
    $file_value = $partialFile->getRealFileValue($partial);
    $label = $partialFile->getUseValue($partial)?'Internal':'External';
    if (!empty($file_value)) {
      $form['file_preview'] = array(
        '#type' => 'fieldset',
        '#title' => t("$label Data"),
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,    
        '#weight' => 0,
      );
      $form['file_preview']['file_value'] = array(
        '#value' => $file_value,
      );
    }
  }
  return $form;
}

/*
function phptemplate_partial_node_form($form) {
  unset($form['preview']);
  unset($form['preview_changes']);
  unset($form['menu']);
  unset($form['submit']);
  
  $output = "\n<div class=\"node-form\">\n";

  // Admin form fields and submit buttons must be rendered first, because
  // they need to go to the bottom of the form, and so should not be part of
  // the catch-all call to drupal_render().
  $admin = '';
  if (isset($form['author'])) {
    $admin .= "    <div class=\"authored\">\n";
    $admin .= drupal_render($form['author']);
    $admin .= "    </div>\n";
  }
  if (isset($form['options'])) {
    $admin .= "    <div class=\"options\">\n";
    $admin .= drupal_render($form['options']);
    $admin .= "    </div>\n";
  }
//  $buttons = drupal_render($form['preview']);
  $buttons .= drupal_render($form['save']);
  $buttons .= drupal_render($form['save_and_edit']);
  $buttons .= isset($form['delete']) ? drupal_render($form['delete']) : '';
  $buttons .= drupal_render($form['cancel']);

  // Everything else gets rendered here, and is displayed before the admin form
  // field and the submit buttons.
  $output .= "  <div class=\"standard\">\n";
  $output .= drupal_render($form);
  $output .= "  </div>\n";

  if (!empty($admin)) {
    $output .= "  <div class=\"admin\">\n";
    $output .= $admin;
    $output .= "  </div>\n";
  }
  $output .= $buttons;
  $output .= "</div>\n";

  return $output;
}
*/
//because diff overwrites the edit form!!!
//function phptemplate_diff_node_form($form) {
 // return phptemplate_partial_node_form($form);
//}

function partial_admin_view($pid) {
  
  $form['tabset'] = array(
    '#type' => 'tabset',
  );
  $form['tabset']['tabPartial'] = array(
    '#type' => 'tabpage',
    '#title' => t('Partial'),
    '#content' => partial_render($pid),
  );
  
  $partial = partial_db_load($pid);

  foreach (partial_files() as $partialFile) {
    $form['tabset']['tab_' . $partialFile->getKey()] = array(
      '#type' => 'tabpage',
      '#title' => t($partialFile->getLabel()),
      '#content' => partial_admin_file_view($partial, $partialFile),
    );
  }

  $form['tabset']['tab_properties'] = array(
    '#type' => 'tabpage',
    '#title' => t('Properties'),
    '#content' => partial_admin_property_view($partial),
  );
  $nodeBody = tabs_render($form);
  return $nodeBody;
}

function partial_admin_property_view($partial) {
  $header = array(t('Name'), t('Label'), t('Type'), t('Attributes'), null);
  if (!empty($partial->properties)) {
    foreach ($partial->properties as $property) {
      $rows[] = array(array('data'=>$property['name']),
                      array('data'=>$property['label']),
                      array('data'=>$property['type']),
                      array('data'=>$property['attributes']),
                      null,
                      );
    }
  }
  $output = theme('table', $header, $rows);
  return $output;
}

function partial_admin_file_view($partial, $partialFile) {
  $template = null;
  if ($partialFile->getUseValue($partial)) {
    $template = '<code>' . $partialFile->getFileValue($partial) . '</code>';
  } else {
    $fullPath = $partialFile->getFullPath($partial);
    if (file_exists($fullPath)) {   
      $fileArray = file($fullPath);
      $template = '<code>' . implode($fileArray) . '</code>';
    }
  }
  if ($template) {
    $template = codefilter_filter('prepare', 0, -1, $template);
    $template = codefilter_filter('process', 0, -1, $template);
    $label = $partialFile->getLabel();
    $key = $partialFile->getKey();
    if ($partialFile->getUseValue($partial)) {
      $template = "<h2>Internal {}</h2><div class='internal$label'>" . $template . '</div>';
    } else {
      $template = "<h2>$label File</h2><div class='file$key'>" . $template . '</div>';
    }
  }
  return $template;
}
/*
function partial_diff(&$old_node, &$new_node) {
  $result = array();
  foreach ($GLOBALS['partial_files'] as $partialFile) {
    $fileField = $partialFile->getFileField();
    $result[] = array(
      'name' => t('Internal ' . $partialFile->getLabel()),
      'old' => explode("\r", $old_node->$fileField),
      'new' => explode("\r", $new_node->$fileField),
    );
  }
  return $result;	
}
	//scheduling
  /*
	if (module_exists('ns_terms')) {
		$form['tabset']['tabInfo']['schedule'] = array(
			'#type' => 'fieldset',
			'#title' => t('Scheduling'),
			'#collapsible' => TRUE,
			'#collapsed' => empty($node->schedule_target_id),
			'#weight'  => 0,
		);
	  $terms = ns_terms_get_all_terms($GLOBALS['user']->rid);
		$form['tabset']['tabInfo']['schedule']['schedule_target_id'] = array(
				'#type' => 'select',
				'#title' => t('Category'),
				'#options' => nodescheduler_term_options($terms),
				'#default_value' => $node->schedule_target_id,
		);
		$form['tabset']['tabInfo']['schedule']['schedule_node'] = array(
			'#title' => t('or enter nid or title'),
			'#type' => 'textfield',
			'#default_value' => $node->schedule_node,
			'#maxlength' => 512,
			'#autocomplete_path' => 'partial/node/autocomplete',
		);
		$form['tabset']['tabInfo']['schedule']['schedule_link'] = array(
				'#type' => 'checkbox',
				'#title' => t('Display schedule link.'),
				'#default_value' => $node->schedule_link,
		);
	}
  */
