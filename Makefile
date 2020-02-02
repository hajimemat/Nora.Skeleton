var/tmp:
	mkdir var/tmp -p
var/cache:
	mkdir var/cache -p
var/logs:
	mkdir var/logs-p
sphinx-preview: var/cache
	sphinx-autobuild -H 0.0.0.0 -p 8001 ./doc ./var/cache/sphinx-autobuild
shphinx-pdf: var/tmp 
	sphinx-build -b latex ./doc ./tmp/sphinx-latex && (cd tmp/sphinx-latex && make) && cp tmp/sphinx-latex/*.pdf build/
