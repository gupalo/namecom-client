.PHONY: all composer test

all: composer test

test:
	docker run --rm -v $(CURDIR):/code/ $(CURDIR)/vendor/bin/phpunit -c $(CURDIR)/phpunit.xml.dist

composer:
	docker run --rm -v $(CURDIR):/code/ composer composer install --ignore-platform-reqs -n -d /code/
