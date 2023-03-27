<?php

/**
 * This file contains an example implementation of
 * invoking a method of a class by terminal commands
 * using CmdOperator class
 */

# Include your class
require_once 'YourClass.php';

# Include cmd_operator.php
require_once 'CmdOperator.php';

try {
    $response = new stdClass();

    # create an instance of your class
    $yourClassInstance = new \CustomNamespace\YourClass();

    # Create an instance of CmdOperator
    $commandOperator = new \Chamithlkml\CmdOperator($yourClassInstance);
    $response = $commandOperator->callMethod();
} catch (Exception $ex) {
    $response->status = 0;
    $response->message = $ex->getMessage();
} catch (Error $er) {
    $response->status = 0;
    $response->message = $er->getMessage();
} catch (Throwable $t) {
    $response->status = 0;
    $response->message = $t->getMessage();
}

# Change the return type as you wish
header("Content-Type: application/json");
echo json_encode($response);
exit();
