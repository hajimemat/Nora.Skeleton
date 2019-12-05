tmp:
	mkdir tmp
var/cache:
	mkdir var/cache -p
preview: var/cache
	PLANTUML="/usr/share/java/plantuml/plantuml.jar -config /home/kurari/nora/TWB.Sen/config.pu" sphinx-autobuild -H 0.0.0.0 -p 8001 ./doc ./var/cache/sphinx-autobuild
pdf: tmp 
	PLANTUML="/usr/share/java/plantuml/plantuml.jar -config /home/kurari/nora/TWB.Sen/config.pu" sphinx-build -b latex ./doc ./tmp/sphinx-latex && (cd tmp/sphinx-latex && make) && cp tmp/sphinx-latex/mrso.pdf dist/
