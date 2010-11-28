po:
	find adressen | egrep ".php$$" > files_to_translate.txt
	find adressen_helper | egrep ".php$$" >> files_to_translate.txt
	xgettext --default-domain=main -k_ --files-from=files_to_translate.txt --from-code=iso-8859-1
	rm files_to_translate.txt
	msginit --locale=en --input=main.po
	
mo:
	msgfmt -o main.mo de_DE.po
