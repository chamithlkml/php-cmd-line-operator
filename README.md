# PHP Command Line Operator
This PHP library can be used to invoke a certain method of a PHP class depending on command line parameters passed to the script.

## Usage
- Create a file called `cmd.php` file
```
<?php
require_once '/path/to/your/console_class.php';
require_once '/path/to/lib/cmd_operator.php';

$my_console_app = new YourConsoleClass();
$command_operator = new \chamithlkml\CmdOperator($my_console_app);
$response = $command_operator->call_method();
```
- Issue the command to execute a particular method in your console app class as follow.

Lets's assume your console app implementation has a public method called `custom_method`
```
class YourConsoleApp{

    public function custom_method($param1=0, $param2=''){
        // Your method implementation
    }
}
```
You may call this method `custom_method` in command line as below
```
php cmd.php --custom_method --param1 100 --param2 abcd
```

## Running Unit Tests
- Install composer by referring to [Composer Docs](https://getcomposer.org/download/)
- Run composer
```
composer install
```
- Navigate to `unit_tests` directory and run the unit tests file
```
cd unit_tests
../vendor/bin/phpunit CmdOperatorTest.php
```
![localImage](./img/unit_test_results.png)

## Docker container
```
docker pull chamithlkml/php-cmd-line-operator
```