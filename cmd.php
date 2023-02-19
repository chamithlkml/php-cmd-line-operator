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
    

    $console_application = new ConsoleApp();
    $command_operator = new CmdOperator($console_application);
    $long_options = $command_operator->get_long_options();
    $command_params = getopt('', $long_options);
    $response = $command_operator->call_method($command_params);
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

if(isset($response->message))
    echo $response->message;

print_r($response);