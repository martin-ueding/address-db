# Copyright (c) 2012 Martin Ueding <dev@martin-ueding.de>

phpfiles:=$(shell find .. -type f -name "*.php")

mofiles:=de_DE/LC_MESSAGES/address_db.mo nl/LC_MESSAGES/address_db.mo tr/LC_MESSAGES/address_db.mo

all: $(mofiles) address_db.pot

address_db.pot: $(phpfiles)
	xgettext --sort-output --language=PHP --from-code=UTF-8 -keywword=_ -o $@ $^
	msgmerge -U de.po $@
	msgmerge -U nl.po $@
	msgmerge -U tr.po $@

de_DE/LC_MESSAGES/address_db.mo: de.po
	mkdir -p $(shell dirname $@)
	msgfmt -o $@ $^

nl/LC_MESSAGES/address_db.mo: nl.po
	mkdir -p $(shell dirname $@)
	msgfmt -o $@ $^

tr/LC_MESSAGES/address_db.mo: tr.po
	mkdir -p $(shell dirname $@)
	msgfmt -o $@ $^

clean:
	$(RM) -r de_DE
	$(RM) -r nl
	$(RM) -r tr
	$(RM) address_db.pot
