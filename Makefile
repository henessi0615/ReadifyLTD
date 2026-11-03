DOCKER_COMPOSE = docker compose

.PHONY: build start stop restart shell stan ecs-fix base-drop base-create base-migration base-migrations-diff base-migrations-migrate base-cache-clear

.DEFAULT_GOAL := start

build:
	$(DOCKER_COMPOSE) build

start:
	$(DOCKER_COMPOSE) up -d --force-recreate --remove-orphans
	$(DOCKER_COMPOSE) exec bookstore composer install --quiet
	@echo ""
	@echo " Readify LTD API running at: http://localhost:8000"
	@echo " Swagger Documentation at: http://localhost:8000/api/doc"
	@echo ""


stop:
	$(DOCKER_COMPOSE) down

restart:
	$(DOCKER_COMPOSE) down && $(DOCKER_COMPOSE) up -d

shell:
	$(DOCKER_COMPOSE) exec bookstore sh

ecs-fix:
	$(DOCKER_COMPOSE) exec bookstore php bin/console cache:clear
	$(DOCKER_COMPOSE) exec bookstore php vendor/bin/ecs check --fix

stan:
	$(DOCKER_COMPOSE) exec bookstore bin/console cache:clear
	$(DOCKER_COMPOSE) exec bookstore php vendor/bin/phpstan analyse
base-drop:
	$(DOCKER_COMPOSE) exec bookstore php bin/console doctrine:schema:drop --force --full-database
base-create:
	$(DOCKER_COMPOSE) exec bookstore php bin/console doctrine:database:create

base-migration:
	$(DOCKER_COMPOSE) exec bookstore php bin/console make:migration

base-migrations-diff:
	$(DOCKER_COMPOSE) exec bookstore php bin/console doctrine:migrations:diff

base-migrations-migrate:
	$(DOCKER_COMPOSE) exec bookstore php bin/console doctrine:migrations:migrate
base-cache-clear:
	$(DOCKER_COMPOSE) exec bookstore php bin/console doctrine:cache:clear-metadata

