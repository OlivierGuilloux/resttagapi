# Rest Tag Api
Place this app in **nextcloud/apps/**

## Tagging files using Rest Tag Api ##

**curl example for systemtag:**

Tagging:
```
curl -X POST -u admin:admin "http://localhost:8080/index.php/apps/resttagapi/api/v1/restapi/Photos/Coast.jpg" -d '{"tags": ["Coast", "Sea"]}' -H "Content-Type: application/json"
```

View tags Id:
```
curl -X GET -u admin:admin "http://localhost:8080/index.php/apps/resttagapi/api/v1/restapi/Photos/Coast.jpg"
{"18":["1","4"]}
```

**curl example for old tag system ! (vcategory):**

Tagging:
```
curl -X POST -u admin:admin "http://localhost:8080/index.php/apps/resttagapi/api/v0/restapi/Photos/Coast.jpg" -d '{"tags": ["Coast", "Sea"]}' -H "Content-Type: application/json"
```

View tags:
```
curl -X GET -u admin:admin "http://localhost:8080/index.php/apps/resttagapi/api/v0/restapi/Photos/Coast.jpg"

{"18":["Coast","Sea"]}
```

**Clear tags:**
```
curl -X POST -u admin:admin "http://localhost:8080/index.php/apps/resttagapi/api/v1/restapi/Photos/Coast.jpg" -d '{"tags": [
```
And check:
```
curl -X GET -u admin:admin "http://localhost:8080/index.php/apps/resttagapi/api/v1/restapi/Photos/Coast.jpg" -H "Content-Type: application/json"
```

## Building the app

The app can be built by using the provided Makefile by running:

    make

This requires the following things to be present:
* make
* which
* tar: for building the archive
* curl: used if phpunit and composer are not installed to fetch them from the web
* npm: for building and testing everything JS, only required if a package.json is placed inside the **js/** folder

The make command will install or update Composer dependencies if a composer.json is present and also **npm run build** if a package.json is present in the **js/** folder. The npm **build** script should use local paths for build systems and package managers, so people that simply want to build the app won't need to install npm libraries globally, e.g.:

**package.json**:
```json
"scripts": {
    "test": "node node_modules/gulp-cli/bin/gulp.js karma",
    "prebuild": "npm install && node_modules/bower/bin/bower install && node_modules/bower/bin/bower update",
    "build": "node node_modules/gulp-cli/bin/gulp.js"
}
```


## Publish to App Store

First get an account for the [App Store](http://apps.nextcloud.com/) then run:

    make && make appstore

The archive is located in build/artifacts/appstore and can then be uploaded to the App Store.

## Running tests
You can use the provided Makefile to run all tests by using:

    make test

This will run the PHP unit and integration tests and if a package.json is present in the **js/** folder will execute **npm run test**

Of course you can also install [PHPUnit](http://phpunit.de/getting-started.html) and use the configurations directly:

    phpunit -c phpunit.xml

or:

    phpunit -c phpunit.integration.xml

for integration tests

# TODO #

* Add tags introspection UI
* Improve file type management
