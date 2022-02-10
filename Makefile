.PHONY: start test check deploy

start:
	php -S 0.0.0.0:8888 -t public/

test:
	clear && vendor/bin/pest --testdox

check:
	clear && vendor/bin/psalm

deploy: test check
	sls deploy
