// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

/**
 * Tells the applet to send its data.
 * 
 * @author Martin Ueding <dev@martin-ueding.de>
 */
public class FertigActionlistener implements ActionListener {
	public void actionPerformed(ActionEvent arg0) {
		BildAusschnitt.myself.geheWeiter();
	}
}
