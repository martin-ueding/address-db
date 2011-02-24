# Copyright (c) 2010 Martin Ueding <dev@martin-ueding.de>

bildAusschnittJavaFiles = $(shell find . | egrep "\.java$$")
../../adressen/ba.jar: $(bildAusschnittJavaFiles)
	javac BildAusschnitt.java
	jar -cfm ../../adressen/ba.jar manifest.txt *.class
	rm *.class
