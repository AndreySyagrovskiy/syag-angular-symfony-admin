.PHONY: build

install:
	npm install
	./node_modules/protractor/bin/webdriver-manager update

run:
	@nice -n 13  ./node_modules/webpack-dev-server/bin/webpack-dev-server.js --colors --devtool source-map --content-base --port 8000

examples/blog/build:
	@mkdir examples/blog/build

build:
	@nice -n 15 NODE_ENV=production ./node_modules/webpack/bin/webpack.js -p --optimize-minimize --optimize-occurence-order --optimize-dedupe --progress --devtool source-map
	@echo "Files build/ng-admin.min.css and build/ng-admin.min.js updated (with minification)"

watch:
	@NODE_ENV=production ./node_modules/webpack/bin/webpack.js -p --watch --optimize-minimize --optimize-occurence-order --optimize-dedupe --progress --devtool source-map
	@echo "Files build/ng-admin.min.css and build/ng-admin.min.js updated (with minification)"

test-unit:
	@./node_modules/.bin/karma start js/test/karma.conf.js --single-run

test-e2e:
	@./node_modules/.bin/grunt test:e2e

test: test-unit test-e2e
