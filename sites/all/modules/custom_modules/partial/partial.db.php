<?php
// $Id$
/**
 * Partials Module
 */
function _partial_db_result($result) {
	$retVal = array();
	while ($partial = db_fetch_object($result)) {
		$retVal[$partial->pid] = $partial;
	}
	return $retVal;
}

function partial_db_get_pid($title) {
  $result = db_fetch_array(db_query(db_rewrite_sql("SELECT pid FROM {partial} WHERE LOWER(title) = LOWER('%s')"), $title));
	if (!empty($result)) {
		return $result['pid'];
	}
}

function partial_db_load_from_title($title) {
  $retVal = db_fetch_object(db_query("SELECT * FROM {partial} WHERE LOWER(title) = LOWER('%s')", $title));
  $retVal->properties = partial_db_load_properties($retVal->pid);
  return $retVal;
}

function partial_db_get_nid($title) {
  $result = db_fetch_array(db_query(db_rewrite_sql("SELECT nid FROM {node} WHERE LOWER(title) = LOWER('%s')"), $title));
	if (!empty($result)) {
		return $result['nid'];
	}
}

function partial_db_get_partials() {
  $header = array(
                    array('data'=>t('Partial'), 'field'=>'title'),
                    array('data'=>t('File'), 'field'=>'partial_file'),
                    array('data'=>t('Page'), 'field'=>'page_url'),
                    array('data'=>t('Simple Page'), 'field'=>'simple_page_url'),
                    array('data'=>t('Block'), 'field'=>'provide_block'),
                    array('data'=>t('View Style'), 'field'=>'provide_view_style'),
                    t('Actions'), null, null, null
                  );
  $tablesort = tablesort_sql($header);
	$result = db_query('select * from {partial}' . $tablesort);
	return _partial_db_result($result);
}

function partial_db_get_virtual_files() {
	$result = db_query('select * from {partial} where (use_internal_js=1 or use_internal_css=1) order by title');
	return _partial_db_result($result);
}

function partial_db_get_view_styles() {
	$result = db_query('select * from {partial} where provide_view_style=1 order by title');
	return _partial_db_result($result);
}

function partial_db_get_blocks() {
	$result = db_query('select * from {partial} where provide_block=1 order by title');
	return _partial_db_result($result);
}

function partial_db_get_pages() {
	$result = db_query('select * from {partial} where provide_page=1 order by title');
	return _partial_db_result($result);
}

function partial_db_get_simple_pages() {
	$result = db_query('select * from {partial} where provide_simple_page=1 order by title');
	return _partial_db_result($result);
}

function partial_db_load($pid) {
  $additions = db_fetch_object(db_query('SELECT * FROM {partial} WHERE pid = %d', $pid));
  $additions->properties = partial_db_load_properties($pid);
  return $additions;
}

function partial_db_load_properties($pid) {
  $result = db_query('SELECT * FROM {partial_properties} WHERE pid = %d', $pid);
  while ($property = db_fetch_array($result)) {
    $properties[$property['name']] = $property;
  }
  return $properties;
}

function partial_db_insert($partial) {
  if ($partial->theme) {
    $theme = $GLOBALS['theme_key'];
  }
  $partial->pid = db_next_id('partial_pid');
  
  db_query("INSERT INTO {partial} (pid, title, module, theme, throttle, partial_description, partial_file, use_folder, node_prefix, " .
           "provide_page, page_title, page_url, provide_simple_page, simple_page_title, simple_page_url, use_internal_template, internal_template, " .
           "use_internal_php, internal_php, use_internal_js, internal_js, use_internal_css, internal_css, " .
           "provide_view_style, provide_block, block_title, view_type, view_columns) " .
           "VALUES (%d, '%s', '%s', '%s', %d, '%s', '%s', %d, %d" .
           ", %d, '%s', '%s', %d, '%s', '%s', %d, '%s'" .
           ", %d, '%s', %d, '%s', %d, '%s'" . 
           ", %d, %d, '%s', '%s', %d)",
           $partial->pid, $partial->title, $partial->module, $theme, $partial->throttle, $partial->partial_description, $partial->partial_file, $partial->use_folder, $partial->node_prefix,
         $partial->provide_page, $partial->page_title, $partial->page_url, $partial->provide_simple_page, $partial->simple_page_title, $partial->simple_page_url, $partial->use_internal_template, $partial->internal_template,
         $partial->use_internal_php, $partial->internal_php, $partial->use_internal_js, $partial->internal_js, $partial->use_internal_css, $partial->internal_css,
           $partial->provide_view_style, $partial->provide_block, $partial->block_title, $partial->view_type, $partial->view_columns);

//  $variables = partial_load_variable_defs($node->partial_file);
  if ($partial->properties) {
    foreach($partial->properties as $key=>$property) {
      db_query("INSERT INTO {partial_properties} (pid, name, label, type, attributes, value) VALUES (%d, '%s', '%s', '%s', '%s', '%s')",
                 $partial->pid, $property['name'], $property['label'], $property['type'], $property['attributes'], $property['value']); 
    }
  }
  return $partial->pid;
}

function partial_db_update($partial) {
  if ($partial->theme) {
    $theme = $GLOBALS['theme_key'];
  }    
  db_query("UPDATE {partial} SET title='%s', module='%s', theme='%s', throttle=%d, partial_description='%s', partial_file='%s', use_folder=%d, node_prefix=%d"
         . ", provide_page=%d, page_title='%s', page_url='%s', provide_simple_page=%d, simple_page_title='%s', simple_page_url='%s', use_internal_template=%d, internal_template='%s'"
         . ", use_internal_php=%d, internal_php='%s', use_internal_js=%d, internal_js='%s', use_internal_css=%d, internal_css='%s'"  
         . ", provide_view_style=%d, provide_block=%d, block_title='%s', view_type='%s', view_columns=%d WHERE pid = %d",
         $partial->title, $partial->module, $theme, $partial->throttle, $partial->partial_description, $partial->partial_file, $partial->use_folder, $partial->node_prefix,
         $partial->provide_page, $partial->page_title, $partial->page_url, $partial->provide_simple_page, $partial->simple_page_title, $partial->simple_page_url, $partial->use_internal_template, $partial->internal_template,
         $partial->use_internal_php, $partial->internal_php, $partial->use_internal_js, $partial->internal_js, $partial->use_internal_css, $partial->internal_css,
       $partial->provide_view_style, $partial->provide_block, $partial->block_title, $partial->view_type, $partial->view_columns, $partial->pid);

  //$variables = partial_load_variable_defs($node->partial_file);
  db_query('DELETE FROM {partial_properties} WHERE pid = %d', $partial->pid);
  if ($partial->properties) {
    foreach($partial->properties as $key=>$property) {
//        $variableName = 'partial_property_' . $key;
//        error_log("found variable vid:$node->vid key:$key value:" . $node->$variableName);
      db_query("INSERT INTO {partial_properties} (pid, name, label, type, attributes, value) VALUES (%d, '%s', '%s', '%s', '%s', '%s')",
               $partial->pid, $property['name'], $property['label'], $property['type'], $property['attributes'], $property['value']); 
    }
  }
}

function partial_db_delete($pid) {
  db_query('DELETE FROM {partial} WHERE pid = %d', $pid);
  db_query('DELETE FROM {partial_properties} WHERE pid = %d', $pid);
}

function partial_db_clear_cache() {
  mysql_query("DELETE from cache WHERE 1");
  mysql_query("DELETE from cache_menu WHERE 1");
  mysql_query("DELETE from cache_page WHERE 1");
  mysql_query("DELETE from cache_filter WHERE 1");
}
