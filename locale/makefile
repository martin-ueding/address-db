# Copyright (c) 2012 Martin Ueding <dev@martin-ueding.de>

phpFiles = $(shell find .. -type f -name "*.php")

phpfamilyaddressdb.pot: $(phpFiles)
	xgettext --sort-output --language=PHP --from-code=UTF-8 -keywword=_ -o $@ $^

de_DE/LC_MESSAGES/phpfamilyaddressdb.mo: de.po
	mkdir -p $(shell dirname $@)
	msgfmt -o $@ $^

nl/LC_MESSAGES/phpfamilyaddressdb.mo: nl.po
	mkdir -p $(shell dirname $@)
	msgfmt -o $@ $^

tr/LC_MESSAGES/phpfamilyaddressdb.mo: tr.po
	mkdir -p $(shell dirname $@)
	msgfmt -o $@ $^
