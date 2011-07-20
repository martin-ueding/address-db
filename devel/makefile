# Copyright (c) 2010 Martin Ueding <dev@martin-ueding.de>

version = 2.3.1
projectName = phpfamilyaddressdb-$(version)

phpFiles = $(shell bzr ls -RV .. | egrep "\.php$$")
moFiles = ../locale/de_DE/LC_MESSAGES/phpfamilyaddressdb.mo ../locale/nl/LC_MESSAGES/phpfamilyaddressdb.mo ../locale/tr/LC_MESSAGES/phpfamilyaddressdb.mo

all: locale/phpfamilyaddressdb.pot $(moFiles) bild-ausschnitt

locale/phpfamilyaddressdb.pot: $(phpFiles)
	xgettext --sort-output --language=PHP --from-code=UTF-8 -keywword=_ -o $@ $^

../locale/de_DE/LC_MESSAGES/phpfamilyaddressdb.mo: locale/de.po
	msgfmt -o $@ $^

../locale/nl/LC_MESSAGES/phpfamilyaddressdb.mo: locale/nl.po
	msgfmt -o $@ $^

../locale/tr/LC_MESSAGES/phpfamilyaddressdb.mo: locale/tr.po
	msgfmt -o $@ $^

tarball: $(projectName).tar.gz

$(projectName).tar.gz: $(phpFiles) $(moFiles) $(jQueryPath) bild-ausschnitt
	tar -czf $@ --exclude=devel --exclude=.bzr* .. 

bild-ausschnitt: ../adressen/ba.jar

../adressen/ba.jar: $(shell find ba-src | egrep "\.java$$")
	make -C ba-src
