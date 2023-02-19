<?php
namespace chamithlkml;
use Exception;
use Error;
use Throwable;
use stdClass;

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'inc.php');

try{
    $command_operator = new CmdOperator();
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
