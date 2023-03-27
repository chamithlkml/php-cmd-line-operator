# PHP Command Line Operator

## Usage
This PHP class can be used to invoke a public method of another PHP class using terminal commands. Please check the example below.

Your PHP Class could be something as below

```
class YourClass{

    public function yourMethod(int $param1 = 0, string $param2 = ''){
        # Your method implementation
    }
}
```
Create a file `Cmd.php` with following content.
```
<?

# Include you class
require_once 'YourClass.php';

# Include CmdOperator.php
require_once 'CmdOperator.php';

try{
    $response = new stdClass();

    # create an instance of your class
    $yourClassInstance = new \CustomNamespace\YourClass();

    # Create an instance of CmdOperator
    $commandOperator = new \Chamithlkml\CmdOperator($yourClassInstance);
    $response = $commandOperator->callMethod();
}catch(Exception $ex){
    $response->status = 0;
    $response->message = $ex->getMessage();
}catch(Error $er){
    $response->status = 0;
    $response->message = $er->getMessage();
}catch(Throwable $t){
    $response->status = 0;
    $response->message = $t->getMessage();
}

# Change the return type as you wish
header("Content-Type: application/json");
echo json_encode($response);
exit();
```
You may call the method `yourMethod` in command line as below
```
php Cmd.php --yourMethod --param1 100 --param2 abcd
```

## Running Unit Tests
- Install composer by referring to [Composer Docs](https://getcomposer.org/download/)
- Run composer
```
composer install
./vendor/bin/phpunit unit_tests
```
![localImage](./img/unit_test_results.png)

## Docker container
```
docker pull chamithlkml/php-cmd-line-operator
```