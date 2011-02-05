version = 2.3.1
projectName = phpfamilyaddressdb-$(version)

phpFiles = $(shell find . | egrep "\.php$$")
moFiles = $(shell find . | egrep "LC_MESSAGES/main.mo$$")

jQueryFilename = jquery-1.5.min.js
jQueryPath = js/$(jQueryFilename)

all: locale/main.pot $(moFiles) $(jQueryPath)

locale/main.pot: $(phpFiles)
	xgettext --sort-output --language=PHP --from-code=UTF-8 -keywword=_ -o locale/main.pot $(phpFiles)

locale/de_DE/LC_MESSAGES/main.mo: locale/de.po
	msgfmt -o locale/de_DE/LC_MESSAGES/main.mo locale/de.po

locale/nl/LC_MESSAGES/main.mo: locale/nl.po
	msgfmt -o locale/de_DE/LC_MESSAGES/main.mo locale/nl.po

locale/tr/LC_MESSAGES/main.mo: locale/tr.po
	msgfmt -o locale/de_DE/LC_MESSAGES/main.mo locale/tr.po

$(jQueryPath):
	wget --output-document=$(jQueryPath) http://code.jquery.com/$(jQueryFilename)

tarball: $(projectName).tar.gz

$(projectName).tar.gz: $(phpFiles) $(moFiles) $(jQueryPath)
	rm -rf $(projectName)
	mkdir $(projectName)
	bzr export $(projectName)
	cp $(jQueryPath) $(projectName)/$(jQueryPath)
	rm $(projectName)/makefile $(projectName)/locale/*.po*
	tar -czf $(projectName).tar.gz $(projectName)
	rm -rf $(projectName)
