<?php
// $Id: archive.inc,v 1.3 2007/07/10 05:43:01 susurrus Exp $

/**
 * * Fetch nodes for the selected date, or current date if none selected.
 *
 * @param $year
 *   Number of year
 *   * @param $month
 *   Number of month
 *   * @param $month
 *   Number of day
 * @return
 *   A string with the themed page
 */
function _archive_page($city, $type = 'all', $year = NULL, $month = NULL, $day = NULL) {
  $date = _archive_date($city, $type, $year, $month, $day);
  $ddnodes = array();
  $output = '';

  // arbitrary number, large enough for a month's worth of daily_doses
  $nodes = 100;
  $query = _archive_query($city, $type, $date, $taxonomy);
  $result = pager_query(array_shift($query), $nodes, 0, NULL, $query);

  if (db_num_rows($result)) {
    while ($node = db_fetch_object($result)) {
      //$output .= node_view(node_load($node->nid), TRUE);
      $itemnode = node_load($node->nid);
      $itemday = date('j', $itemnode->created);
      $ddnodes[$itemday] = theme('dd_archive_node', $itemnode, $itemday);
    }
    //$output .= theme('pager', NULL, $nodes);
  }
  elseif ($date->days[$date->day] > 0) {
    drupal_goto(_archive_url($city, 'all', $date, $date->year, $date->month, $date->day));
  }
  elseif ($date->months[$date->month] > 0) {
    drupal_goto(_archive_url($city, 'all', $date, $date->year, $date->month));
  }
  elseif ($date->year[$date->year] > 0) {
    drupal_goto(_archive_url($city, 'all', $date, $date->year));
  }
  //no archive for the year and/or city and/or taxonomy
  else {
    $output = 'No archive for this period.';
  }
//  drupal_set_title("Daily Dose - Archive");
  $output = theme('dd_archive_page', $city, $type, $date, $ddnodes);
  return $output;
}

/**
 * Parses the current URL and populates an archive
 * date object with the selected date information.
 *
 * @param $year
 *   Number of year
 * @param $month
 *   Number of month
 * @param $month
 *   Number of day
 * @return
 *   A date object with GMT date values and a timezone value
 */
function _archive_date($city, $type, $year = NULL, $month = NULL, $day = NULL) {
  static $date = null;

  if ($date != null) {
    return $date;
  }
  $date->tz = _archive_get_timezone();
  $date->now = time();

  $date->year  = 0;
  $date->month = 0;
  $date->day   = 0;

  if (_archive_validate_year($year)) {
    $date->year = $year;
    if (_archive_validate_month($month)) {
      $date->month = $month;
      if (_archive_validate_day($year, $month, $day)) {
         $date->day = $day;
      }
    }
  }
  else {
    $date->year = gmdate('Y', $date->now + $date->tz);
  }

  $date->start_of_month = gmmktime(0, 0, 0, $date->month, 1, $date->year);
  $date->month_last_day = gmdate('t', $date->start_of_month);
  $date->end_of_month   = gmmktime(23, 59, 59, $date->month, $date->month_last_day, $date->year);

  $date->years  = _archive_years($city, $type, $date);
  $date->months = _archive_months($city, $type, $date);
  $date->days   = _archive_days($city, $type, $date);

  return $date;
}

/**
 * Builds an SQL query array (query and parameters) to use
 * to display an archive page for the specified date.
 *
 * @param $date
 *    A date object obtained from _archive_date()
 * @return
 *    An array of (query, param_start, param_end)
 */
function _archive_query($city, $type, $date, $taxonomy) {

  if ($date->day > 0 && $date->month > 0) {
    // Confine the display interval to only one day
    $start = gmmktime(0, 0, 0, $date->month, $date->day, $date->year);
    $end   = gmmktime(0, 0, 0, $date->month, $date->day + 1, $date->year);
  }
  elseif ($date->month > 0) {
    // Confine the display interval to one month
    $start = gmmktime(0, 0, 0, $date->month, 1, $date->year);
    $end   = gmmktime(0, 0, 0, $date->month + 1, 1, $date->year);
  }
  else {
    // Confine the display interval to one year
    $start = gmmktime(0, 0, 0, 1, 1, $date->year);
    $end   = gmmktime(0, 0, 0, 1, 1, $date->year + 1);
  }
  $final_types = _archive_types_sql_string($type);
  if($type == 'all') {
    $sql = array('SELECT n.nid, n.type FROM {node} n, {term_node} tn WHERE n.nid = tn.nid AND tn.tid = %d '. $final_types .' AND n.status = 1 AND n.created >= %d AND n.created < %d ORDER BY n.created DESC', $city->field_taxonomy_id[0]['value'], $start - $date->tz, $end - $date->tz);
  }
  else {
    $cats = _dd_archive_categories();
    //add city support here
    $sql = array('SELECT n.nid FROM node n JOIN term_node tn ON n.nid = tn.nid JOIN term_node tnn ON  n.nid = tnn.nid JOIN term_data td ON  tn.tid = td.tid WHERE td.name LIKE "%s" AND tnn.tid = %d AND n.status = 1 AND n.created >= %d AND n.created < %d '
                 . $final_types .'ORDER BY n.created DESC', $cats[$type], $city->field_taxonomy_id[0]['value'], $start - $date->tz, $end - $date->tz);
//    $sql = array('SELECT n.nid FROM node n JOIN term_node tn ON n.nid = tn.nid JOIN term_node tnn ON  n.nid = tnn.nid JOIN term_data td ON  tn.tid = td.tid JOIN term_data tdd ON  tnn.tid = tdd.tid WHERE td.name LIKE "%s" AND tdd.name LIKE "%s" AND n.status = 1 AND n.created >= %d AND n.created < %d '. $final_types .'ORDER BY n.created DESC', $cats[$type], $city, $start - $date->tz, $end - $date->tz);
  }
  return $sql;
}

/**
 * Builds a SQL statement to check that the appropriate
 * node types are being returned
 *
 * @param $type
 *    The current type we're filtering
 * @return
 *    A SQL string
 */
function _archive_types_sql_string($type){
  // Validate type and specify node types to include
  $final_types = '';
  if (_archive_validate_type($type) && $type != 'all') {
    $final_types = $type;
  }
  else {
    $types = variable_get('archive_type_filters', array());
    // If no checkboxes selected
    if (!array_key_exists('0', $types)) {
      foreach ($types as $key => $value) {
        if (!$value) {
          unset($types[$key]);
        }
      }
      $final_types = join(array_keys($types), '", "');
    }
  }
  if (strlen($final_types) > 0) {
    $final_types = 'AND n.type IN ("' . $final_types . '") ';
  }
  return $final_types;
}

/**
 * Returns the range of years with nodes.
 *
 * @param $type
 *    The object that is being filtered
 * @param $date
 *    A date object obtained from _archive_date()
 * @return
 *    An array of the (first year with posts, last year with posts).
 */
function _archive_years($city, $type, $date) {
  $final_types = _archive_types_sql_string($type);
  $result = db_query('SELECT MIN(created) AS min_date, MAX(created) AS max_date FROM {node} n, {term_node} tn WHERE n.nid = tn.nid AND tn.tid = %d AND n.status = 1 ' . $final_types, $city->field_taxonomy_id[0]['value']);
  $min_max = db_fetch_object($result);
  return array(gmdate('Y', $min_max->min_date + $date->tz), gmdate('Y', $min_max->max_date + $date->tz));
}

/**
 * Returns the months of a given year which have nodes.
 * Note: FROM_UNIXTIME could be used, but it is MySQL only and has timezone issues.
 *
 * @param $type
 *    The current type we're filtering
 * @param $date
 *    A date object obtained from _archive_date()
 * @return
 *    An array of months with number of posts for each.
 */
function _archive_months($city, $type, $date) {
  $final_types = _archive_types_sql_string($type);
  $months_with_posts = array();
  foreach (range(1, 12) as $month) {
    $start  = gmmktime(0, 0, 0, $month, 1, $date->year) - $date->tz;
    $end    = gmmktime(0, 0, 0, $month + 1, 1, $date->year) - $date->tz;
    $result = db_query('SELECT COUNT(*) AS count FROM {node} n, {term_node} tn WHERE n.nid = tn.nid AND tn.tid = %d AND n.status = 1 ' . $final_types . 'AND n.created >= %d AND n.created < %d', $city->field_taxonomy_id[0]['value'], $start, $end);
    $row = db_fetch_object($result);
    $months_with_posts[$month] = $row->count;
  }
  return $months_with_posts;
}

/**
 * Returns the days of a given month which have nodes.
 *
 * @param $type
 *    The current node type we're filtering
 * @param $date
 *    A date object obtained from _archive_date()
 * @return
 *    An array of days having posts with number of posts for each.
 */
function _archive_days($city, $type, $date) {
  $final_types = _archive_types_sql_string($type);

  $result = db_query('SELECT n.nid, n.created FROM {node} n, {term_node} tn WHERE n.nid = tn.nid AND tn.tid = %d AND n.status = 1 ' . $final_types . 'AND n.created BETWEEN %d AND %d ORDER BY n.created', $city->field_taxonomy_id[0]['value'], $date->start_of_month - $date->tz, $date->end_of_month - $date->tz);

  $days_with_posts = array();
  while ($day_with_post = db_fetch_object($result)) {
    $daynum = gmdate('j', $day_with_post->created + $date->tz);
    if (isset($days_with_posts[$daynum])) {
      $days_with_posts[$daynum]++;
    }
    else {
      $days_with_posts[$daynum] = 1;
    }
  }

  return $days_with_posts;
}

/**
 * Returns the different node types that have nodes
 *
 * @param $date
 *    A date object obtained from _archive_date()
 * @return
 *    An array of node-types to number of posts of that type
 */
function _archive_node_types($date) {

  $types = variable_get('archive_type_filters', array());
  if ($types[0] == '1') {
    return array();
  }
  foreach ($types as $key => $value) {
    if (!$value) {
      unset($types[$key]);
    }
    else {
      $types[$key] = 0;
    }
  }
  if ($date->day > 0 && $date->month > 0) {
    // Confine the display interval to only one day
    $start = gmmktime(0, 0, 0, $date->month, $date->day, $date->year);
    $end   = gmmktime(0, 0, 0, $date->month, $date->day + 1, $date->year);
  }
  elseif ($date->month > 0) {
    // Confine the display interval to one month
    $start = gmmktime(0, 0, 0, $date->month, 1, $date->year);
    $end   = gmmktime(0, 0, 0, $date->month + 1, 1, $date->year);
  }
  else {
    // Confine the display interval to one year
    $start = gmmktime(0, 0, 0, 1, 1, $date->year);
    $end   = gmmktime(0, 0, 0, 1, 1, $date->year + 1);
  }
  $result = db_query('SELECT t.type, t.name, COUNT(n.nid) AS node_count FROM {node} n INNER JOIN {node_type} t ON t.type = n.type WHERE n.status = 1 AND t.type IN ("' . join(array_keys($types), '", "') . '") AND n.created BETWEEN %d AND %d GROUP BY n.type ORDER BY n.created', $start - $date->tz, $end - $date->tz);

  $n_types['all'] = array('count' => 0,
                          'name'  => t('All'));

  while ($row = db_fetch_array($result)) {
    $n_types[$row['type']] = array('count' => $row['node_count'],
                                   'name'  => $row['name']);
    $n_types['all']['count'] += $row['node_count'];
  }

  ksort($n_types);
  return $n_types;
}

/**
 * Check if given year is valid for a Drupal archive
 *
 * @param $year
 *    The year to check
 * @return
 *    TRUE or FALSE
 */
function _archive_validate_year($year) {
  return (1990 < $year && $year < 2040);
}

/**
 * Check if given month is valid.
 *
 * @param $month
 *    The month to check
 * @return
 *    TRUE or FALSE
 */
function _archive_validate_month($month) {
  return (1 <= $month && $month <= 12);
}

/**
 * Check if given year, month and date combination
 * is valid for a Drupal archive.
 *
 * @param $year
 *    The year to check
 * @param $month
 *    The month to check
 * @param $day
 *    The day to check
 * @return
 *    TRUE or FALSE
 */
function _archive_validate_day($year, $month, $day) {
  if (_archive_validate_month($month) && _archive_validate_year($year)) {
    // Number of days for that month
    $last = gmdate('t', gmmktime(0, 0, 0, $month, 1, $year));
    return (1 <= $day && $day <= $last);
  }
  else {
    return FALSE;
  }
}

/**
 * Check if given node type is valid for a Drupal archive
 *
 * @param $type
 *    The type to check
 * @return
 *    TRUE or FALSE
 */
function _archive_validate_type($type) {
  $types = variable_get('archive_type_filters', array());
  foreach ($types as $key => $value) {
    if (!$value) {
      unset($types[$key]);
    }
    else {
      $types[$key] = 0;
    }
  }
  return in_array($type, array_keys($types));
}

/**
 * Generate an archive URL based on the $y, $m and $d
 * provided, falling back on the $date properties if
 * an invalid date is specified.
 *
 * Validation checking included for $date properties,
 * because those could be zero, if not defined from the
 * URL.
 *
 * @param $type
 *    The node type to use if valid
 * @param $y
 *    The year to use if valid
 * @param $m
 *    The month to use if valid
 * @param $d
 *    The day to use if valid
 * @return
 *    A string with the generated archive URL
 */
function _archive_url($city, $type, $date, $y = 0, $m = 0, $d = 0) {
  $url = $city->field_city_url_path[0]['value'] . '/archive';

  if (_archive_validate_type($type)) {
    $url .= '/' . $type;
  }
  else {
    $url .= '/all';
  }

  if (_archive_validate_year($y)) {
    $url .= '/'. $y;
    if (_archive_validate_month($m)) {
      $url .= '/'. $m;
      if (_archive_validate_day($y, $m, $d)) {
        $url .= '/'. $d;
      }
    }
  }
  elseif (_archive_validate_year($date->year) && _archive_validate_month($m)) {
    $url .= '/'. $date->year .'/'. $m;
    if (_archive_validate_day($date->year, $m, $d)) {
      $url .= '/'. $d;
    }
  }
  elseif (_archive_validate_year($date->year) && _archive_validate_month($date->month)) {
    $url .= '/'. $date->year .'/'. $date->month;
    if (_archive_validate_day($date->year, $date->month, $d)) {
      $url .= '/'. $d;
    }
  }
  return $url;
}

/**
 * Determine timezone to use for the dates (from format_date)
 *
 * @return
 *   Timezone offset to use in time operations
 */
function _archive_get_timezone() {
  global $user;
  if (variable_get('configurable_timezones', 1) && $user->uid && strlen($user->timezone)) {
    return $user->timezone;
  }
  else {
    return variable_get('date_default_timezone', 0);
  }
}

/**
 * Theme the archive navigation with years, months and dates by default.
 * @ingroup themeable
 */
function theme_archive_navigation($type, $date) {
  $output  = "<div id=\"archive-container\"><dl><dt>". t('Date') ."</dt><dd>\n";
  $output .= theme('archive_navigation_years', $type, $date);
  if (_archive_validate_year($date->year)) {
    $output .= theme('archive_navigation_months', $type, $date);
  }
  if (_archive_validate_month($date->month)) {
    $output .= theme('archive_navigation_days', $type, $date);
  }
  $output .= "</dd>";
  // Only display node type filter if more than one node type represented
  if (sizeof(_archive_node_types($date)) > 2) {
    $output .= "<dt>". t('Type') ."</dt><dd>\n";
    $output .= theme('archive_navigation_node_types', $type, $date);
    $output .= "</dd>";
  }
  $output .= "</dl></div>\n";
  return $output;
}

/**
 * Theme the list of years for the archive navigation.
 * @ingroup themeable
 */
function theme_archive_navigation_years($type, $date) {
  $num_to_display = 3;
  $right_offset = min(gmdate('Y', $date->now + $date->tz) - $date->year, 2);
  $left_offset  = $num_to_display - $right_offset;

  $output = "<ul id=\"archive-years\">\n";
  for ($year = ($date->year - $left_offset); $year <= $date->year + $right_offset; $year++) {
    $class = '';

    if ($year > gmdate('Y', $date->now + $date->tz)) {
      $class = ' class="future"';
    }
    elseif ($year == $date->year) {
      $class = ' class="selected"';
    }

    $name = gmdate('Y', gmmktime(0, 0, 0, 1, 1, $year));
    if (min($date->years) <= $year && $year <= max($date->years)) {
        $output .= "<li$class>". l($name, _archive_url($type, $date, $year)). "</li>\n";
    }
    else {
      $output .= "<li$class>$name</li>\n";
    }
  }
  $output .= "</ul>\n";

  return $output;
}

/**
 * Theme the list of months for the archive navigation.
 * @ingroup themeable
 */
function theme_archive_navigation_months($type, $date) {
  $output = "<ul id=\"archive-months\">\n";
  foreach (range(1, 12) as $month) {
    $posts = !empty($date->months[$month]) ? $date->months[$month] : 0;
    $class = ($month == $date->month) ? ' class="selected"' : '';
    $name = t(gmdate('M', gmmktime(0, 0, 0, $month, 1, $date->year)));
    $output .= "<li$class>". ($posts > 0 ? l($name, _archive_url($type, $date, 0, $month), array('title' => format_plural($posts, "1 post", "@count posts"))) : $name) ."</li>\n";
  }
  $output .= "</ul>\n";
  return $output;
}

/**
 * Theme the list of days for the archive navigation.
 * @ingroup themeable
 */
function theme_archive_navigation_days($type, $date) {
  $output = "";
  $day_stop = gmdate('t', gmmktime(0, 0, 0, $date->month, 1, $date->year));
  $output = "<ul id=\"archive-days\">\n";

  for ($day = 1; $day <= $day_stop; $day++) {
    $posts = !empty($date->days[$day]) ? $date->days[$day] : 0;
    $class = ($day == $date->day) ? ' class="selected"' : '';
    $name = gmdate('d', gmmktime(0, 0, 0, $date->month, $day, $date->year));
    $output .= "<li$class>". ($posts ? l($name, _archive_url($type, $date, 0, 0, $day), array("title" => format_plural($posts, "1 post", "@count posts"))) : $name) ."</li>\n";
  }
  $output .= "</ul>\n";
  return $output;
}

/**
 * Theme the list of node types for the archives
 * @ingroup themeable
 */
function theme_archive_navigation_node_types($type, $date) {
  $output = "";
  $output = "<ul id=\"archive-node_types\">\n";

  $types_count = _archive_node_types($date);
  foreach ($types_count as $ft_key => $ft_value) {
    if (!$ft_value['count']) {
      continue;
    }
    $class = ($ft_key == $type ? ' class="selected"' : '');
    $name = $ft_value['name'];
    if ($types_count[$ft_key]['count'] > 0) {
      $output .= "<li$class>". l($name, _archive_url($ft_key, $date, $date->year, $date->month, $date->day), array("title" => format_plural($types_count[$ft_key]['count'], "1 post", "@count posts"))) ."</li>\n";
    }
    else {
      $output .= "<li$class>$name</li>\n";
    }
  }
  $output .= "</ul>\n";
  return $output;
}
/*
function _dd_archive_city() {
  if(strtolower($_SERVER['HTTP_HOST']) == 'vitamint.ca') {
    $city = 'toronto';
  }
  elseif(strtolower($_SERVER['HTTP_HOST']) == 'vitaminm.ca') {
    $city = 'montreal';
  }
  else {
    $city = 'vancouver';
  }
  return $city;
}
*/
function _dd_archive_categories() {
  $cats = array(
            'health-beauty' => 'HEALTH & BEAUTY',
            'fashion-shopping' => 'FASHION & SHOPPING',
            'home-decor' => 'HOME & DECOR',
            'arts-culture' => 'ARTS & CULTURE',
            'travel-leisure' => 'TRAVEL & LEISURE',
            'dining-nightlife' => 'DINING & NIGHTLIFE',
            'moms-kids' => 'MOMS & KIDS',
          );
  return $cats;
}
?>
