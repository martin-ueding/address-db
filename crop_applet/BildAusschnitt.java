// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

import java.applet.Applet;
import java.awt.BorderLayout;
import java.awt.Button;
import java.awt.Color;
import java.awt.Image;
import java.awt.event.MouseMotionListener;
import java.net.MalformedURLException;
import java.net.URL;

/**
 * Crops a picture. It displays the picture in original size and offers a set of cropping boundaries to set the new image size. The result is then send as a GET request.
 * 
 * @author Martin Ueding <dev@martin-ueding.de>
 */
@SuppressWarnings("serial")
public class BildAusschnitt extends Applet {
	static Image bild;
	static Button b;
	static BilderPanel bPanel;
	
	static MouseMotionListener lauscher;
	
	static BildAusschnitt myself;
	
	public void init() {
		myself = this;
		
		showStatus("Bild wird geladen...");
		
		
		String url = getParameter("bildurl");
		if (url == null || url.equals(""))
			url = "brille.jpg";

		bild = getImage(getCodeBase(), url);

		
		showStatus("Bild geladen");
		
		
		
		
		setLayout(new BorderLayout());
		
		b = new Button("Fertig");
		b.addActionListener(new FertigActionlistener());
		b.setEnabled(false);
	
		
		bPanel = new BilderPanel();
		
		try {
			bPanel.farbe = new Color(Integer.parseInt(getParameter("rot")), Integer.parseInt(getParameter("gruen")), Integer.parseInt(getParameter("blau")));
		} catch (Exception any) {
			bPanel.farbe = Color.RED;
		}
		
		try {
			bPanel.farbe2 = new Color(Integer.parseInt(getParameter("rot2")), Integer.parseInt(getParameter("gruen2")), Integer.parseInt(getParameter("blau2")));
		} catch (Exception any) {
			bPanel.farbe2 = Color.WHITE;
		}
		
		try {
			BilderPanel.ANFASSERBREITE = Integer.parseInt(getParameter("anfasserbreite"));
		} catch (Exception any) {
			BilderPanel.ANFASSERBREITE = 5;
		}
		
		add(bPanel, BorderLayout.CENTER);
		add(b, BorderLayout.SOUTH);
		
		try {
			bPanel.ratio = Double.parseDouble(getParameter("seitenv"));
			
			if (bPanel.ratio != 0.0)
				bPanel.rechts = (bPanel.unten-bPanel.oben)*bPanel.ratio+bPanel.links;
			
		} catch (Exception irgnored) {};
	}
	
	public void start() {
		lauscher = new BilderMouseMotionListener();
		bPanel.addMouseMotionListener(lauscher);
	}
	
	public void stop() {
		bPanel.removeMouseMotionListener(lauscher);
	}
	
	/**
	 * Tells the applet to send its data with a GET request to the PHP script that does the cropping.
	 */
	void geheWeiter() {
		try {
			getAppletContext().showDocument(new URL(getParameter("zieladresse") + "&bild="+getParameter("bildurl")+"&x1="+(int)bPanel.links+"&y1="+(int)bPanel.oben+"&x2="+(int)bPanel.rechts+"&y2="+(int)bPanel.unten));
		} catch (MalformedURLException e) {
			e.printStackTrace();
		}
	}
	
}
