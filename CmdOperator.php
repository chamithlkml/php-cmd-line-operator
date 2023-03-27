<?php

/**
 * This file contains the code for CmdOperator class
 */

namespace Chamithlkml;

use ReflectionClass;
use ReflectionMethod;
use stdClass;
use Exception;

/**
 * Main class invoking client's custom class methods with the attributes provided.
 */
class CmdOperator
{
    /**
     * Array containing the valid methods to be called in your class
     * provided in creating the instance of this class
     */
    private array $validMethods = [];

    /**
     * An associative array containing key=>value parameters of the issued command
     */
    private array $commandParams = [];

    public function __construct(
        private $classInstance = null
    ) {
    }

    /**
     * Call the respective valid method of the given instance of the user class
     *
     * @return object
     */
    public function callMethod(): object
    {
        $this->setCommandParams();
        $validMethod = $this->getValidMethod();

        if ($validMethod == 'help') {
            //@todo Write a detailed help message
        }

        $relatedParams = $this->getRelatedParams($validMethod);

        $response = new stdClass();
        $response->result = call_user_func_array(array($this->classInstance, $validMethod), $relatedParams);

        return $response;
    }

    /**
     * Read public methods and their arguments of provided class instance and set user inputs as an associative array
     */
    private function setCommandParams(): void
    {
        $reflClass = new ReflectionClass($this->classInstance);
        $reflMethods = $reflClass->getMethods(ReflectionMethod::IS_PUBLIC);

        # long_options need to be passed to getopt function
        $options = [];

        foreach ($reflMethods as $reflMethod) {
            if (!in_array($reflMethod->name, $options)) {
                $options[] = $reflMethod->name . '::';
            }

            if (!array_key_exists($reflMethod->name, $this->validMethods)) {
                $this->validMethods[$reflMethod->name] = [];
            }

            $reflParameters = $reflClass->getMethod($reflMethod->name)->getParameters();

            foreach ($reflParameters as $reflParameter) {
                $this->validMethods[$reflMethod->name][] = $reflParameter->name;

                if (!in_array($reflParameter->name, $options)) {
                    $options[] = $reflParameter->name . ':';
                }
            }
        }

        $this->commandParams = getopt('', $options);
    }

    /**
     * Returns an array of related params of a given method of the users class
     * @param string $validMethod
     * @return array
     */
    private function getRelatedParams($validMethod = ''): array
    {
        $relatedParams = [];

        foreach ($this->validMethods[$validMethod] as $param) {
            if (!isset($this->commandParams[$param])) {
                throw new Exception("Parameter `--{$param}` not found in the command issued");
            }

            $relatedParams[] = $this->commandParams[$param];
        }

        return $relatedParams;
    }

    /**
     * Returns the valid method suitable to execute depending on the params supplied by the user on shell
     *
     * @return string
     */
    private function getValidMethod(): string
    {
        $validMethods = [];

        foreach ($this->commandParams as $key => $value) {
            if (array_key_exists($key, $this->validMethods) && !$value) {
                $validMethods[] = $key;
            }
        }

        # If no valid method is given, an error message is thrown and the execution must be hault
        if (count($validMethods) == 0) {
            throw new Exception("Please specify a method name to call as `--method_name` of your class");
        } elseif (count($validMethods) > 1) {
            throw new Exception("More than one method found in the command issued");
        }
        return $validMethods[0];
    }
}
