
-- Overview --------------------------------------------------------------------

The Constant Contact (CC) module is a Drupal interface to CC to allow managing
your contacts on your CC mailing Lists.

Unfortunately, the CC API is rather thin, so you will need to set up your lists
using CC interface before you can manage the contacts via Drupal.

If you want to manage other information than just the email address, you will to
enable and use the profile module. This also allows to add your mailing lists
to the user registration. See the Configuration section.

It also is possible that you want to start using this module and already have a
CC account and populated lists. No problems, see the Configuration section.

-- Installation ----------------------------------------------------------------

This module requires the profile module to be enabled.

1. Go to Administer -> Site building -> Modules: enable both the Profile and
   Constant Contact modules.

2. Go to Administer -> User management -> Access control: grant the various
   access to the desired roles.

2. Go to Administer -> Site Configuration -> Constant Contact setting: fill in
   your CC account information, fill in the CC / Drupal relationships fields
   (more info above).


-- Configuration ---------------------------------------------------------------

-- Profile matching --
For passing more than just the email address to CC, the Name of the fields you
create in a profile (Administer -> User management -> Profiles) will need to be
paired up with the correct CC field. To do so, proceed to Administer -> Site
Configuration -> Constant Contact Settings and expand the CC / Drupal
relationships fieldset. For the desired CC elements, enter the corresponding
profile field name. For example, if you want to have the first name added to
your CC mailing list, you may set a profile field with the name
profile_firstname. Then in the CC / Drupal relationships, in the First Name
field you would enter profile_firstname.

-- Bulk import --
To perform a bulk import of contacts using a CSV file, proceed to Administer ->
Site Configuration -> Constant Contact Settings and expand the CSV fieldset.
Note that if you select the 'Update Constant Contact Lists', the process will
update your current contact in CC, so backup you CC lists first! Also beware of
the fact that when running a bulk import, the lists associated with a given user
will be overwritten and NOT appended. This means that if ms_x@xdomain.com is a
recipient of List1 and that you run an import with his email selecting only List2
she will be remove from List1.

-- Anonymous unsubscribe --
You may want to allow your contact to unregister from your lists without
requiring them to create a Drupal account. If this is the case, click the
'Allow anonymous unsubscribe' on the Administer -> Site Configuration ->
Constant Contact setting page. You will be able to create a link to
cclists/unsubscribe which allows anonymous users to proceed with usubscription.

-- Bugs/Features/Patches -------------------------------------------------------

If you want to report bugs, have feature requests, or submit a patch, please
visit the project page on the Drupal web site.


-- Author ----------------------------------------------------------------------

Developed and maintained by Francis Pilon for Raincity Studios.
http://raincitystudios.com
