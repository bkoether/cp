<?php

/* $Id: crud.inc,v 1.9 2007/04/02 07:05:20 borismann Exp $ */

/* --- PROFILE FUNCTIONS --- */

function install_profile_field_add($data) {
	if (!is_array($data) || !isset($data['title']) || !isset($data['name'])) {
	  return false;
	}
	$data['fid'] = db_next_id("{profile_fields}_fid");
	$data['category'] = ($data['category']) ? $data['category'] : '';
	$data['type'] = ($data['type']) ? $data['type'] : 'textfield';
	$data['required'] = ($data['required']) ? $data['required'] : '0';
	$data['register'] = ($data['register']) ? $data['register'] : '0';
	$data['visibility'] = ($data['visibility']) ? $data['visibility'] : '0';
	$data['explanation'] = ($data['explanation']) ? $data['explanation'] : '';
	
	$fields = array_keys($data);
	
	// Prepare the query:
	foreach ($data as $key => $value) {
	  if (in_array((string) $key, $fields)) {
	    $k[] = db_escape_string($key);
	    $v[] = $value;
	    $s[] = "'%s'";
	  }
	}
	db_query("INSERT INTO {profile_fields} (". implode(", ", $k) .") VALUES (". implode(", ", $s) .")", $v);
	
	return $data['fid'];
}

/* --- ROLE FUNCTIONS --- */

/**
 * Add a role to the roles table.
 */
function install_add_role($name) {
  db_query("INSERT INTO {role} (name) VALUES ('%s')", $name);
  return install_get_rid($name);
}

/**
 * Get the role id for the role name
 */
function install_get_rid($name) {
  return db_result(db_query("SELECT rid FROM {role} WHERE name ='%s' LIMIT 1", $name));
}

/* --- MENU FUNCTIONS --- */

/**
 * Set the permission for a certain role
 */
function install_set_permissions($rid, $perms) {
  db_query('DELETE FROM {permission} WHERE rid = %d', $rid);
  db_query("INSERT INTO {permission} (rid, perm) VALUES (%d, '%s')", $rid, implode(', ', $perms));
}

/**
 * Create a new top-level menu
 * @return	integer		The database ID of the newly created menu
 */
function install_menu_create_menu($title, $weight = 0) {
  $mid = db_next_id('{menu}_mid');
  // Check explicitly for mid <= 2. If the database was improperly prefixed,
  // this would cause a nasty infinite loop or duplicate mid errors.
  // TODO: have automatic prefixing through an installer to prevent this.
  while ($mid <= 2) {
    $mid = db_next_id('{menu}_mid');
  }
  db_query("INSERT INTO {menu} (mid, pid, title, weight, type) VALUES (%d, 0, '%s', %d, 115)", $mid, $title, $weight);
  menu_rebuild(); // not sure if this is needed, but we've seen problems without it
  return $mid; // this is important to add new items to this menu.
}

/**
 * Get the menu ID, searching on path
 * @return	integer		The database ID of a menu item based on its path
 */
function install_menu_get_mid($path) {
  menu_rebuild(); // not sure if this is needed, but we've seen problems without it
  return db_result(db_query("SELECT mid FROM {menu} WHERE path = '%s' LIMIT 1", $path));	
}

/**
 * Get the menu ID of a root menu, based on title, e.g. Secondary links
 * @return	integer		The database ID of the root menu that matches the $title
 */
function install_menu_get_root_menu($title) {
  return db_result(db_query("SELECT mid FROM {menu} WHERE title = '%s' LIMIT 1", $title));	
}

/**
 * Set an existing menu ID to a new parent
 */
function install_menu_set_menu($mid, $pid, $type = 54) {
  db_query("UPDATE {menu} SET pid = %d, type = %d WHERE mid = %d", $pid, $type, $mid);
  menu_rebuild(); // not sure if this is needed, but we've seen problems without it
}

/**
 * Create a new menu item
 * @return	integer	The database ID of the menu item
 */
function install_menu_create_menu_item($path, $title, $pid, $description = '', $weight = 0, $type = 118) {
  $menu = array(
    'path' => $path,
    'title' => st($title),
    'pid' => $pid,
    'description' => st($description),
    'weight' => $weight,
    'type' => $type
  );
  menu_save_item($menu);
  
  menu_rebuild(); // not sure if this is needed, but we've seen problems without it
  
  return install_menu_get_mid($path); // this is important to add new items to this menu.
}

function install_menu_disable_item($mid) { 
  $item = menu_get_item($mid);
  $type = $item['type'];
  $type &= ~MENU_VISIBLE_IN_TREE;
  $type &= ~MENU_VISIBLE_IN_BREADCRUMB;
  $type |= MENU_MODIFIED_BY_ADMIN;
  db_query('UPDATE {menu} SET type = %d WHERE mid = %d', $type, $mid);
  drupal_set_message(t('The menu item has been disabled.'));
  // No redirection during install
  //drupal_goto('admin/build/menu');
}

/* --- TINYMCE --- */

/**
 * Add roles to an existing TinyMCE profile identified by the profile name
 */
function install_tinymce_add_roles($name, $roles) {
  foreach ($roles as $role) {
    db_query("INSERT INTO {tinymce_role} (name, rid) VALUES ('%s', %d)", $name, $role);
  }
}

/**
 * Create a new TinyMCE profile and set the settings
 * @param	$name		A text string identifying the profile
 * @param	$settings	An associative array containing key value pairs
 */
function install_tinymce_create_profile($name, $settings) {
  db_query("INSERT INTO {tinymce_settings} (name, settings) VALUES ('%s', '%s')", $name, serialize($settings));
}

/* --- TAXONOMY --- */

/**
 * Given the name of a vocabulary, return its Vocab ID
 * @param	$name		A text string identifying the vocabulary
 */
function install_get_vid($name) {
  // not guaranteed to be unique, hence the LIMIT
  return db_result(db_query("SELECT vid FROM {vocabulary} WHERE name = '%s' LIMIT 1", $name));
};

/* --- FILTER --- */

/**
 * Set the roles that can be used with the filter 
 * @param	$roles		An array of role IDs
 * @param	$format_id	An integer of the format ID
 */
function install_format_set_roles($roles, $format_id) {
  $roles = implode(',',$roles);	
  db_query("UPDATE {filter_formats} SET roles = '%s' WHERE format = %d", $roles, $format_id);
}

/**
 * Add a new input format 
 * @param	$name	The human-readable name of the new format
 * @param	$cache	If this format is cacheable
 */
function install_add_format($name, $cache = 1) {
  $format_id = db_next_id('{filter_formats}_fid');
  // Check explicitly for format_id <= 3. If the database was improperly prefixed,
  // this would cause a nasty infinite loop or duplicate mid errors.
  // TODO: have automatic prefixing through an installer to prevent this.
  while ($format_id <= 3) {
    $format_id = db_next_id('{filter_formats}_fid');
  }
  db_query("INSERT INTO {filter_formats} (`format`, `name`, `roles`, `cache`) VALUES (%d, '%s', '', %d)", $format_id, $name, $cache);
  return $format_id;
}

/**
 * Remove the specified filter from the specified format 
 * @param	$format_id	The ID of the format to remove the filter from
 * @param	$module		The module this filter belongs to
 * @param	$delta		The delta of this filter
 *
 * NOTE: the module name + the delta is what uniquely identifies a filter
 */
function install_remove_filter($format_id, $module, $delta) {	
  db_query("DELETE FROM {filters} WHERE format = %d AND module = '%s' AND delta = %d", $format_id, $module, $delta);
}

/**
 * Add a filter to an input format
 * @param	$format_id	The ID of the format to add the filter to
 * @param	$module		The module this filter belongs to
 * @param	$delta		The delta of this filter
 * @param	$weight		The weight to be applied to this filter
 */
function install_add_filter($format_id, $module, $delta = 0, $weight = 0) {
  db_query("INSERT INTO {filters} (`format`, `module`, `delta`, `weight`) VALUES (%d, '%s', %d, %d)", $format_id, $module, $delta, $weight);
}
  