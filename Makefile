install:
	docker run --rm -ti -v "$$PWD":/app -v "$$HOME/.composer:/.composer" --user "$$(id -u):$$(id -g)" -w /app composer install

start:
	docker-compose up -d

setup_db:
	docker-compose exec web bin/console doctrine:schema:drop --force --full-database
	docker-compose exec web bin/console doctrine:schema:create

test: check_layers phpunit

check_layers:
	bin/check-layers

phpunit:
	docker-compose exec web bin/phpunit
