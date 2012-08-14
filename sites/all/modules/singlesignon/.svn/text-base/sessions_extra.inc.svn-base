<?php
// $Id: sessions_extra.inc,v 1.2.2.2 2008/05/06 00:55:59 wayland76 Exp $

/**
 * @file
 *   This file contains extra functions that do things with sessions that are 
 *   not in core, but are required for the Shared Sign-on (singlesignon) module
 * 
 * @link     http://drupal.org/project/singlesignon
 * @author   Primary Author: Daniel Convissor <danielc@analysisandsolutions.com>
 * @author   Maintainer: Tim Nelson <wayland@wayland.id.au>
 * @version  $Revision: 1.2.2.2 $
 */

/**
 * When a user is logging out, we assume that they want to completely log out 
 * of all our sites; the only way to do this (until session tracks on a 
 * per-domain basis or session merging works) is to delete all sessions
 * (except of course the current one, which is needed for Drupal's regular
 * logout process which takes place after this).  
 */
function _singlesignon_session_logout($uid) {
  db_query("DELETE FROM {sessions} WHERE uid = %d AND sid <> '%s'", $uid, session_id());
}

/**
 * On the assumption that the user is already logged in to the master server, 
 * update the slave session's user ID to be the user ID they have on the 
 * master server
 */
function _singlesignon_session_update_user() {
// The line below doesn't work in Postgres: http://drupal.org/node/254752 -- the guy in that bug recommended the change
//  db_query("UPDATE {sessions} AS sess_slave LEFT JOIN {sessions} AS sess_master ON (sess_master.sid = '%s' AND sess_slave.sid = '%s') SET sess_slave.uid = sess_master.uid WHERE sess_slave.sid = '%s'", session_id(), $_GET['slave_session'], $_GET['slave_session']);
  $result = db_query("SELECT uid FROM {sessions} WHERE sid = '%s'", session_id());
  if ($master_uid = db_result($result)) {
    db_query("UPDATE {sessions} SET uid = %d WHERE sid = '%s'", $master_uid, $_GET['slave_session']);
  }
}

/**
 * Update all sessions' user IDs to the current one.
 */
function _singlesignon_session_update_all_uids($uid) {
  $in   = substr(str_repeat("'%s',", count($_SESSION['singlesignon_slave_sessions'])), 0, -1);
  $sql  = "UPDATE {sessions} SET uid = %d WHERE sid IN ($in)"; // I know the coder module complains about this, but it appears to be necessary in this case
  $args = array_merge(array($sql), array($uid), $_SESSION['singlesignon_slave_sessions']);
  call_user_func_array('db_query', $args);
}

/**
 * User is coming to the master site to say they just logged on to a slave.  
 * Set master site's user ID to be their one from the slave.
 */
function _singlesignon_session_login(&$user) {
  $result    = db_query("SELECT uid FROM {sessions} WHERE sid = '%s'", $_GET['slave_session']);
  $row       = db_fetch_array($result);
  $user->uid = $row['uid'];

  // Update all sessions' user IDs to the current one.
  _singlesignon_session_update_all_uids($user->uid);
}
