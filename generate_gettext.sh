#!/bin/bash
xgettext --language=PHP --from-code=UTF-8 -keywword=_ -o locale/main.pot adressen/*.php adressen/*/*.php adressen_helper/*.php
#
#msgfmt -o locale/de_DE/LC_MESSAGES/main.mo locale/de.po

