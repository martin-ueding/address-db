# Copyright (c) 2010 Martin Ueding <dev@martin-ueding.de>

bildAusschnittJavaFiles = $(shell find . | egrep "\.java$$")
../../adressen/ba.jar: $(bildAusschnittJavaFiles)
	javac BildAusschnitt.java
	jar -cfm $@ manifest.txt *.class
	rm *.class
