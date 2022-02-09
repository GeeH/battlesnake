.PHONY: start test

start:
	php -S 0.0.0.0:8888 -t public/
test:
	clear && vendor/bin/pest --testdox
