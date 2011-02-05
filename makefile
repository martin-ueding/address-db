version = 2.3.1
pname = phpfamilyaddressdb-$(version)

phpFiles = $(shell find . | egrep "\.php$$")
moFiles = $(shell find . | egrep "LC_MESSAGES/main.mo$$")

all: locale/main.pot $(moFiles)

locale/main.pot: $(phpFiles)
	xgettext --sort-output --language=PHP --from-code=UTF-8 -keywword=_ -o locale/main.pot $(phpFiles)

locale/de_DE/LC_MESSAGES/main.mo: locale/de.po
	msgfmt -o locale/de_DE/LC_MESSAGES/main.mo locale/de.po

locale/nl/LC_MESSAGES/main.mo: locale/nl.po
	msgfmt -o locale/de_DE/LC_MESSAGES/main.mo locale/nl.po

locale/tr/LC_MESSAGES/main.mo: locale/tr.po
	msgfmt -o locale/de_DE/LC_MESSAGES/main.mo locale/tr.po

tarball: $(pname).tar.gz

$(pname).tar.gz: $(phpFiles) $(moFiles)
	mkdir $(pname)
	bzr export $(pname)
	tar -czf $(pname).tar.gz $(pname)
	rm -rf $(pname)
