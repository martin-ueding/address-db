# Copyright (c) 2010 Martin Ueding <dev@martin-ueding.de>

version = 2.3.1
projectName = phpfamilyaddressdb-$(version)

phpFiles = $(shell find .. -type f -name "*.php")

all: locale/phpfamilyaddressdb.pot $(moFiles) bild-ausschnitt

tarball: $(projectName).tar.gz

$(projectName).tar.gz: $(phpFiles) $(moFiles) $(jQueryPath) bild-ausschnitt
	tar -czf $@ --exclude=devel --exclude=.bzr* .. 

bild-ausschnitt: ../adressen/ba.jar

../adressen/ba.jar: $(shell find ba-src | egrep "\.java$$")
	make -C ba-src
