<?php
namespace chamithlkml;
use ReflectionClass;
use ReflectionMethod;
use stdClass;
use Exception;

class CmdOperator{

    /**
     * Array containing the valid methods to be called in your console app class provided in creating the instance of this class
     */
    private array $valid_methods = [];

    /**
     * An associative array containing key=>value parameters of the issued command
     */
    private array $command_params = [];

    public function __construct(
        private $console_application_instance=null
    ){}

    /**
     * Call the respective valid method of the given instance of the user class
     *
     * @return object
     */
    public function call_method(): object
    {
        $this->set_command_params();
        $valid_method = $this->get_valid_method();

        $related_params = $this->get_related_params($valid_method);
        
        $response = new stdClass();
        $response->result = call_user_func_array(array($this->console_application_instance, $valid_method), $related_params);
        
        return $response;
    }

    /**
     * Read public methods and their arguments of provided class instance and set user inputs as an associative array
     */
    private function set_command_params(): void
    {
        $refl_class = new ReflectionClass($this->console_application_instance);
        $refl_methods = $refl_class->getMethods(ReflectionMethod::IS_PUBLIC);
        
        # long_options need to be passed to getopt function
        $options = [];

        foreach($refl_methods as $refl_method){

            if(!in_array($refl_method->name, $options))
            {
                $options[] = $refl_method->name . '::';
            }
            
            if(!array_key_exists($refl_method->name, $this->valid_methods))
            {
                $this->valid_methods[$refl_method->name] = [];
            }

            $refl_parameters = $refl_class->getMethod($refl_method->name)->getParameters();

            foreach($refl_parameters as $refl_parameter)
            {
                $this->valid_methods[$refl_method->name][] = $refl_parameter->name;

                if(!in_array($refl_parameter->name, $options))
                {
                    $options[] = $refl_parameter->name . ':';
                }
            }
        }

        $this->command_params = getopt('', $options);
    }

    /**
     * Returns an array of related params of a given method of the users class
     * @param string $valid_method
     * @return array
     */
    private function get_related_params($valid_method = ''): array
    {
        $related_params = [];

        foreach($this->valid_methods[$valid_method] as $param)
        {
            if(!isset($this->command_params[$param]))
            {
                throw new Exception("Parameter `--{$param}` not found in the command issued");
            }

            $related_params[] = $this->command_params[$param];
        }

        return $related_params;
    }

    /**
     * Returns the valid method suitable to execute depending on the params supplied by the user on shell
     *
     * @return string
     */
    private function get_valid_method(): string
    {
        $valid_methods = [];

        foreach($this->command_params as $key=>$value)
        {
            if(array_key_exists($key, $this->valid_methods) && !$value)
            {
                $valid_methods[] = $key;
            }
        }

        # If no valid method is given, an error message is thrown and the execution must be hault
        if(count($valid_methods) == 0)
        {
            throw new Exception("Please specify a method name to call as `--method_name` of your console app class");
        }
        # If more than one methods found in command params, an exception must be thrown
        else if(count($valid_methods) > 1)
        {
            throw new Exception("More than one method found in the command issued");
        }

        return $valid_methods[0];
    }
}