.. Copyright © 2013 Martin Ueding <dev@martin-ueding.de>

#########
Changelog
#########

v3.2
    * Database access in database.ini file.
    * Dynamic page title works now.
    * Fix searchhints.
    * Order birthdays by their date.
    * Save iCal as download file.
    * Start with CakePHP compatible export.
    * Use ISO date format.
    * Use jQuery to toggle manual address entry.

    - Add ``Controller::layout`` selector.
    - Convert to UTF-8.

v3.1.1
    * Fix cell phone carrier on family cell phone.

    - Refactoring.

v3.1
    * Go back on the list when a person is selected on group change.

v3.0.2
    * Fix group list.

    - Less spacing between group lists.

v3.0.1
    * Update German l10n.

v3.0
    * Filter navigation.
    * Navigation in columns.
    * Remove verification mail feature.
    * Selected group is static now.

    - Consistent 3D border effects.
    - Fix: Do not show January when there are no birthdays in list.
    - Fix: Keep mode when changing groups.
    - L10n works again.
    - No size limit on picture upload (just PHP limit).
    - Remove picture crop applet (automatic resize only now).
    
    * History management, automatically go back to last interesting page.
    * Lots of phpdoc documentation.
    * Model-View-Controller backend with helpers and components and templates.

    - Implement zebra in tables with CSS.
    - JOIN in database queries.
    - Join person create and edit templates.
    - Put JavaScript into separate files.

v2.3.2
    * Fix: Error when creating a new area code.

    - Address selection field one line high.

v2.3.1
    * Add some web tests.
    * CSS based menu.
    * NL language support.
    * Warning when deleting a person that belong to other people as well.

    - AJAX search hints.
    - Add copyright notices.
    - Convert some include files into classes.
    - Fix: Remove PHP notices.
    - Fix: Version div does not overlap the alphabet.
    - Kitchen export (uses LaTeX).
    - Past birthdays are displayed in gray.
    - Person awareness for birthday list.
    - Use international Google maps.
    - Use jQuery from CDN.
    - Use ngettext for correct plural forms.

v2.3
    * Internationalisation.
    * Language chooser.
    * List for people without email address.
    * Name in mailto links.
    * Search obeys personal mode.
    * jQuery menus.

    - Add bug report link.
    - Language chooser for verification mail.
    - Support for Bing maps.
    - Support for OpenStreetMap.

v2.2
    * Alphabet bar on right side.
    * Data integrity check.
    * Keep location after changing modes.
    * Navigation in ubiquitous header.

    - 24 hour block for verification email.
    - Add favicon.
    - Changing page title.
    - HTML5 doctype.
    - Intelligent date function.
    - Remember time of last edit.
    - Search box in header.
    - Use PHPMailer.
    - Various fixes.
    - jQuery effects.

v1.0
    * Add SQL Scheme.
    * Add install guide.
    * Initial check-in to version control.

    - Add more error support.
    - Distinguish birth name by gender.
    - Separate HU table.
