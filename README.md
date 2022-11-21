# EventDiaryPHPBackend

PHP University project created by Piotr Wojcik


## Windows VSCode Project Set up

Project was developed under windows 10. To set up the project follow below steps

1. Download VS Code and XAMPP with default settings.
2. Add "C:\xampp\php\" to windows PATH system variable.
3. In VS Code, download "PHP Server" extension and "PHP Intelephense" extensions.<br>
**Important note:** Notice of "PHP Intelephense" pre download steps.
4. enjoy!

## How to launch project on PHP server

1. In VS Code right click somewhere in php file.
2. click in showed options: "PHP Server: Serve project"
3. after finishing of testing PHP do the same however with: "PHP Server: Stop server".
**Important note**
MySQL server is required to be also run for full functionality.

## How to configure local environment

1. Navigate to project_path/config/Database.php
2. Change database variables to match your database set up
3. For database creation open project_path/scripts/createAll.php in a browser
4. if You see 'success' in a browser your setup is complete.

## How to set up Swagger for REST API testing

1. Set up your local environment (How to configure local environment)
2. install composer globally on your computer and add it to path
3. install composer components mentioned in composer.json file
4. run php server for project (How to launch project on PHP server)
5. run Swagger in the browser PHP_server_address:PHP_server_port/doc e.g. http://localhost:3000/doc

**Important Note**
- Some HTTP requests will not work in Swagger without JWT token specified in HTTP Header.
- to get JWT token execute /api/v1/user/login.php with example data specified