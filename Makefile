DOCKER_COMPOSE=docker-compose

.env:
	cp .env.dist .env

_compose_up: .env
	$(DOCKER_COMPOSE) up -d

_compose_down: .env
	$(DOCKER_COMPOSE) down --remove-orphans

_compose_down_into_the_sea: .env
	$(DOCKER_COMPOSE) down --rmi all --volumes --remove-orphans

_compose_override_cp:
	cp docker-compose.override.yaml.dist docker-compose.override.yaml

_composer-install:
	$(DOCKER_COMPOSE) exec php-fpm composer install --no-interaction

_doctrine-migrate:
	$(DOCKER_COMPOSE) exec php-fpm php bin/console doctrine:migrations:migrate --no-interaction

_common-init: _composer-install _doctrine-migrate

init: _compose_up _common-init
init-dev: _compose_override_cp _compose_up _common-init
down: _compose_down
down-into-the-sea: _compose_down_into_the_sea

.PHONY: init init-dev down down-into-the-sea
