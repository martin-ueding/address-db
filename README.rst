.. Copyright © 2012, 2017 Martin Ueding <dev@martin-ueding.de>

################
Address Database
################

A address database for a whole family written in PHP. One can host this on a
family web server and let everyone share their addresses.

This is one of my earliest PHP projects. Compared to my current standards, the
code was pretty horrible. I have refactored it a little bit during the last
years, but it is still mostly a mess.

The advantage against other address books is that I can share the data with my
family. Since we have a lot of contacts in common, it makes sense to let the
closest contact maintain the data for everyone.

Another difference to other address books is that contacts can share an address and associated phone numbers. This makes it easier to update a landline phone number for a whole family.

Bugs
====

- search hints have wrong encoding

- When toggling to the manual input for an address, the telephone area code
  switches are not initialized properly.
