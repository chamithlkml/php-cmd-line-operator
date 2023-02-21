<?php
namespace chamithlkml;
use Exception;
use Error;
use Throwable;
use stdClass;

# Include you console app related dependencies
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'your_console_app.php');

# Include cmd_operator.php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'cmd_operator.php');

try{
    $response = new stdClass();

    # create an instance of your Console app class
    $console_application = new \custom_namespace\YourConsoleApp();

    # Create an instance of CmdOperator
    $command_operator = new CmdOperator($console_application);
    $response = $command_operator->call_method();
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