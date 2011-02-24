// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

import java.awt.Color;
import java.awt.Graphics;
import java.awt.Panel;

public class BilderPanel extends Panel {

	/**
	 * 
	 */
	private static final long serialVersionUID = 7743063808910040729L;

	Color farbe, farbe2;

	double links=20, oben=20, unten=60, rechts=60;

	public double ratio = 0;

	public static int ANFASSERBREITE;



	public void paint(Graphics g) {
		g.drawImage(BildAusschnitt.bild, 0, 0, this);

		g.setColor(farbe);

		g.drawRect((int)links, (int)oben, (int)(rechts-links), (int)(unten-oben));


		g.setColor(farbe2);

		g.fillRect((int)links-ANFASSERBREITE, (int)oben-ANFASSERBREITE, ANFASSERBREITE*2, ANFASSERBREITE*2);
		g.fillRect((int)links-ANFASSERBREITE, (int)unten-ANFASSERBREITE, ANFASSERBREITE*2, ANFASSERBREITE*2);
		g.fillRect((int)rechts-ANFASSERBREITE, (int)oben-ANFASSERBREITE, ANFASSERBREITE*2, ANFASSERBREITE*2);
		g.fillRect((int)rechts-ANFASSERBREITE, (int)unten-ANFASSERBREITE, ANFASSERBREITE*2, ANFASSERBREITE*2);

		g.drawLine((int)(links+rechts)/2-5, (int)(oben+unten)/2, (int)(links+rechts)/2+5, (int)(oben+unten)/2);
		g.drawLine((int)(links+rechts)/2, (int)(oben+unten)/2-5, (int)(links+rechts)/2, (int)(oben+unten)/2+5);

		if (ratio == 0.0) {
			g.fillRect((int)links-ANFASSERBREITE, (int)(oben+unten)/2-ANFASSERBREITE, ANFASSERBREITE*2, ANFASSERBREITE*2);	// Mitte Links
			g.fillRect((int)rechts-ANFASSERBREITE, (int)(oben+unten)/2-ANFASSERBREITE, ANFASSERBREITE*2, ANFASSERBREITE*2);	// Mitte Rechts
			g.fillRect((int)(links+rechts)/2-ANFASSERBREITE, (int)oben-ANFASSERBREITE, ANFASSERBREITE*2, ANFASSERBREITE*2);	// Mitte Oben
			g.fillRect((int)(links+rechts)/2-ANFASSERBREITE, (int)unten-ANFASSERBREITE, ANFASSERBREITE*2, ANFASSERBREITE*2);	// Mitte Unten
		}
	}

}
