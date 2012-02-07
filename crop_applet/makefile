# Copyright (c) 2010 Martin Ueding <dev@martin-ueding.de>

include ../makefile.common

javafiles := $(wildcard *.java)
classfiles := $(javafiles:.java=.class)

../adressen/ba.jar: manifest.txt $(classfiles)
	jar -cfm $@ $^

clean:
	rm *.class
