

import java.awt.Point;
import java.awt.event.MouseEvent;
import java.awt.event.MouseMotionListener;

public class BilderMouseMotionListener implements MouseMotionListener {

	Point pos;
	int ecke = 0;

	final int AB = BilderPanel.ANFASSERBREITE;
	final double ratio = BildAusschnitt.bPanel.ratio;

	private boolean abstand(int x, int y, double links, double rechts, double oben, double unten) {
		return y >= oben && y <= unten && x >= links && x <= rechts;
	}

	public void mouseDragged(MouseEvent d) {

		if (abstand(pos.x, pos.y, BildAusschnitt.bPanel.links-AB, BildAusschnitt.bPanel.links+AB, BildAusschnitt.bPanel.oben-AB, BildAusschnitt.bPanel.oben+AB)) {
			ecke = 1;
		}
		else if (abstand(pos.x, pos.y, BildAusschnitt.bPanel.rechts-AB, BildAusschnitt.bPanel.rechts+AB, BildAusschnitt.bPanel.oben-AB, BildAusschnitt.bPanel.oben+AB)) {
			ecke = 2;
		}
		else if (abstand(pos.x, pos.y, BildAusschnitt.bPanel.links-AB, BildAusschnitt.bPanel.links+AB, BildAusschnitt.bPanel.unten-AB, BildAusschnitt.bPanel.unten+AB)) {
			ecke = 3;
		}
		else if (abstand(pos.x, pos.y, BildAusschnitt.bPanel.rechts-AB, BildAusschnitt.bPanel.rechts+AB, BildAusschnitt.bPanel.unten-AB, BildAusschnitt.bPanel.unten+AB)) {
			ecke = 4;
		}

		else if (abstand(pos.x, pos.y, (BildAusschnitt.bPanel.links+BildAusschnitt.bPanel.rechts)/2-AB, (BildAusschnitt.bPanel.links+BildAusschnitt.bPanel.rechts)/2+AB, BildAusschnitt.bPanel.oben-AB, BildAusschnitt.bPanel.oben+AB)) {
			ecke = 5;
		}
		else if (abstand(pos.x, pos.y, (BildAusschnitt.bPanel.links+BildAusschnitt.bPanel.rechts)/2-AB, (BildAusschnitt.bPanel.links+BildAusschnitt.bPanel.rechts)/2+AB, BildAusschnitt.bPanel.unten-AB, BildAusschnitt.bPanel.unten+AB)) {
			ecke = 6;
		}
		else if (abstand(pos.x, pos.y, BildAusschnitt.bPanel.links-AB, BildAusschnitt.bPanel.links+AB, (BildAusschnitt.bPanel.oben+BildAusschnitt.bPanel.unten)/2-AB, (BildAusschnitt.bPanel.oben+BildAusschnitt.bPanel.unten)/2+AB)) {
			ecke = 7;
		}
		else if (abstand(pos.x, pos.y, BildAusschnitt.bPanel.rechts-AB, BildAusschnitt.bPanel.rechts+AB, (BildAusschnitt.bPanel.oben+BildAusschnitt.bPanel.unten)/2-AB, (BildAusschnitt.bPanel.oben+BildAusschnitt.bPanel.unten)/2+AB)) {
			ecke = 8;
		}

		if (ecke != 0 && ratio != 0.0) {

			if (ecke == 1) {
				BildAusschnitt.bPanel.links += Math.abs(d.getPoint().x - pos.x) > Math.abs(d.getPoint().y - pos.y) ? d.getPoint().x - pos.x : (d.getPoint().y - pos.y)*ratio;
				BildAusschnitt.bPanel.oben += Math.abs(d.getPoint().x - pos.x) > Math.abs(d.getPoint().y - pos.y) ? (d.getPoint().x - pos.x)/ratio : d.getPoint().y - pos.y;
			}
			else if (ecke == 2) {
				BildAusschnitt.bPanel.rechts += Math.abs((d.getPoint().x - pos.x)) > -Math.abs((d.getPoint().y - pos.y)) ? d.getPoint().x - pos.x : (d.getPoint().y - pos.y)*ratio;
				BildAusschnitt.bPanel.oben -= Math.abs((d.getPoint().x - pos.x)) > -Math.abs((d.getPoint().y - pos.y)) ? (d.getPoint().x - pos.x)/ratio : d.getPoint().y - pos.y;
			}
			else if (ecke == 3) {
				BildAusschnitt.bPanel.links += Math.abs((d.getPoint().x - pos.x)) > -Math.abs((d.getPoint().y - pos.y)) ? d.getPoint().x - pos.x : (d.getPoint().y - pos.y)*ratio;
				BildAusschnitt.bPanel.unten -= Math.abs((d.getPoint().x - pos.x)) > -Math.abs((d.getPoint().y - pos.y)) ? (d.getPoint().x - pos.x)/ratio : d.getPoint().y - pos.y;
			}
			else if (ecke == 4) {
				BildAusschnitt.bPanel.rechts += Math.abs((d.getPoint().x - pos.x)) > Math.abs((d.getPoint().y - pos.y)) ? d.getPoint().x - pos.x : (d.getPoint().y - pos.y)*ratio;
				BildAusschnitt.bPanel.unten += Math.abs((d.getPoint().x - pos.x)) > Math.abs((d.getPoint().y - pos.y)) ? (d.getPoint().x - pos.x)/ratio : d.getPoint().y - pos.y;
			}
		}

		else if (ecke != 0) {

			if (ecke == 1) {
				BildAusschnitt.bPanel.links += d.getPoint().x - pos.x;
				BildAusschnitt.bPanel.oben += d.getPoint().y - pos.y;
			}
			else if (ecke == 2) {
				BildAusschnitt.bPanel.rechts += d.getPoint().x - pos.x;
				BildAusschnitt.bPanel.oben += d.getPoint().y - pos.y;
			}
			else if (ecke == 3) {
				BildAusschnitt.bPanel.links += d.getPoint().x - pos.x;
				BildAusschnitt.bPanel.unten += d.getPoint().y - pos.y;
			}
			else if (ecke == 4) {
				BildAusschnitt.bPanel.rechts += d.getPoint().x - pos.x;
				BildAusschnitt.bPanel.unten += d.getPoint().y - pos.y;
			}


			else if (ecke == 5) {
				BildAusschnitt.bPanel.oben += d.getPoint().y - pos.y;
			}
			else if (ecke == 6) {
				BildAusschnitt.bPanel.unten += d.getPoint().y - pos.y;
			}
			else if (ecke == 7) {
				BildAusschnitt.bPanel.links += d.getPoint().x - pos.x;
			}
			else if (ecke == 8) {
				BildAusschnitt.bPanel.rechts += d.getPoint().x - pos.x;
			}


		}




		else {
			BildAusschnitt.bPanel.oben += d.getPoint().y - pos.y;
			BildAusschnitt.bPanel.unten += d.getPoint().y - pos.y;

			BildAusschnitt.bPanel.links += d.getPoint().x - pos.x;
			BildAusschnitt.bPanel.rechts += d.getPoint().x - pos.x;
		}




		if (BildAusschnitt.bPanel.oben < 0) {
			BildAusschnitt.bPanel.unten -= BildAusschnitt.bPanel.oben;
			BildAusschnitt.bPanel.oben -= BildAusschnitt.bPanel.oben;
		}
		else if (BildAusschnitt.bPanel.unten > BildAusschnitt.bild.getHeight(BildAusschnitt.bPanel)) {
			BildAusschnitt.bPanel.oben -= BildAusschnitt.bPanel.unten - BildAusschnitt.bild.getHeight(BildAusschnitt.bPanel);
			BildAusschnitt.bPanel.unten -= BildAusschnitt.bPanel.unten - BildAusschnitt.bild.getHeight(BildAusschnitt.bPanel);
		}


		if (BildAusschnitt.bPanel.links < 0) {
			BildAusschnitt.bPanel.rechts -= BildAusschnitt.bPanel.links;
			BildAusschnitt.bPanel.links -= BildAusschnitt.bPanel.links;
		}
		else if (BildAusschnitt.bPanel.rechts > BildAusschnitt.bild.getWidth(BildAusschnitt.bPanel)) {
			BildAusschnitt.bPanel.links -= BildAusschnitt.bPanel.rechts - BildAusschnitt.bild.getWidth(BildAusschnitt.bPanel);
			BildAusschnitt.bPanel.rechts -= BildAusschnitt.bPanel.rechts - BildAusschnitt.bild.getWidth(BildAusschnitt.bPanel);
		}




		pos = d.getPoint();

		BildAusschnitt.bPanel.repaint();

		BildAusschnitt.b.setEnabled(true);
	}

	public void mouseMoved(MouseEvent m) {
		// TODO Auto-generated method stub

		pos = m.getPoint();

		ecke = 0;

	}

}
