po:
	xgettext --default-domain=main -k_ adressen/index.php
mo:
	msgfmt -o main.mo de_DE.po
