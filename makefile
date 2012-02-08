# Copyright (c) 2012 Martin Ueding <dev@martin-ueding.de>

all:
	make -C css
	make -C locale

clean:
	$(RM) -r html
	make clean -C css
	make clean -C locale
