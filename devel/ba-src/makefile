bildAusschnittJavaFiles = $(shell find . | egrep "\.java$$")
../../adressen/ba.jar: $(bildAusschnittJavaFiles)
	javac BildAusschnitt.java
	jar -cfm ../../adressen/ba.jar manifest.txt *.class
	rm *.class
