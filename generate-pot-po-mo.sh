#!/usr/bin/env bash

namespace=${PWD##*/}
language="de_DE"

#generate POT file from source
find . -name "*.php" > filelist
xgettext --keyword=__ --keyword=_e --keyword=__n:1,2 --files-from=filelist --language=PHP -o languages/${namespace}.pot
rm -f filelist

cd languages
touch ${namespace}-${language}.po

#update German PO file from POT
msgmerge --update --no-fuzzy-matching --backup=off ${namespace}-${language}.po ${namespace}.pot

#update MO file from PO file
msgcat ${namespace}-${language}.po | msgfmt -o ${namespace}-${language}.mo -