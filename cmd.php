<?php
namespace chamithlkml;
use custom_namespace;
use custom_namespace\ConsoleApp;
use Exception;
use Error;
use Throwable;
use stdClass;

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'inc.php');

try{
    $response = new stdClass();
    $response->status = true;
    

    $console_application = new ConsoleApp();
    $command_operator = new CmdOperator($console_application);
    $actions = $command_operator->get_actions();
    print_r($actions);
}catch(Exception $ex){
    $response = new stdClass();
    $response->status = 0;
    $response->message = $ex->getMessage();

}catch(Error $er){
    $response = new stdClass();
    $response->status = 0;
    $response->message = $er->getMessage();
}catch(Throwable $t){
    $response = new stdClass();
    $response->status = 0;
    $response->message = $t->getMessage();
}

print_r($response);