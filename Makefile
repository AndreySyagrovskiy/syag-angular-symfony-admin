.PHONY: build

loadfix:
	php bin/console doctrine:schema:drop  --force
	php bin/console doctrine:schema:create
	php bin/console doctrine:fixtures:load