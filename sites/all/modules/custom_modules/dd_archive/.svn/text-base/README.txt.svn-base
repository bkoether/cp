This is replacement for the Drupal archive.module which was available in
Drupal core in Drupal 4.7.x and previous versions. It does not provide
a calendar, but does provide yearly, monthly and daily browsing navigation.

Alternatives:
  Weekly archive module: http://drupal.org/node/15804
  Periodical module: http://drupal.org/node/14252
  Views module (much more general): eg. http://drupal.org/node/52037 

Originally by CodeMonkeyX

--------------------------------------------------------------------------------
*Developer* notes on timezone handling:

 - Drupal sets $node->created to time() on node creation and storage
 - Then on display it invokes format_date() to get a date display,
   which adds a timezone to the timestamp and then uses gmdate()
 => This means that "time() + timezone" is used as the displayed date

 - Archive module sets today to time() + timezone to conform
 - SQL injected timestamps should have timezone substracted, since
   we need to move the window on the queried nodes "back" to get
   nodes for the date the user expects to get
 - Displayed timestamps should have timezone added to them
 - Archive module uses "gm" functions, so that the server timezone
   is not added upon the used timestamps
--------------------------------------------------------------------------------
