PATH_DOCKER_RESOURCES = ./
PROJECT_NAME		  = guestbook
DOCKER_COMPOSE        = docker-compose -p $(PROJECT_NAME)

## Public
.PHONY: update
update:
	$(DOCKER_COMPOSE) pull
	$(DOCKER_COMPOSE) build php

.PHONY: dev
dev: _dev_start_up composer

.PHONY: stop
stop:
	$(DOCKER_COMPOSE) stop

.PHONY: console
console:
	$(DOCKER_COMPOSE) run --rm php bash < /dev/tty

.PHONY: composer
composer:
	$(DOCKER_COMPOSE) run --rm php composer install

.PHONY: pre-commit
pre-commit:
	$(DOCKER_COMPOSE) run --rm php vendor/bin/php-cs-fixer fix src/

## Private
.PHONY: _dev_start_up
_dev_start_up:
	$(DOCKER_COMPOSE) up -d
