# Installation of the PHP family address database

1.  database access data
	First you have to set up the database, please fill in the appropriate data
in `database.ini`.

2.  create the files in the MySQL database
	There is an sql file with the tables in `install/mysql_tables.sql`. Please
run it with your favorite sql tool, like phpMyAdmin.

3.  set up some users for htaccess
	In order to protect the database you will need to enter some user names in
the `.htpasswd` file. The easiest way to do this is with the htpasswd
tool.

4.  set up family members
	For everybody in your family, there needs to be an entry in the fmg table
so that people can be tagged within the family.

5.  delete the install directory
	There is no reason the install directory should remain on your server. So
please remove it.
