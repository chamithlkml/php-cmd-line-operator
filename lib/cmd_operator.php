<?php
namespace chamithlkml;
use ReflectionClass;
use ReflectionMethod;
use stdClass;
use Exception;

class CmdOperator{

    public function __construct(
        private $console_application_instance=null,
        private array $valid_methods = []
    ){}

    public function get_long_options(): array
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

        return $options;
    }

    public function call_method($command_params = array()): object
    {
        $valid_method = $this->get_valid_method($command_params);
        $related_params = $this->get_related_params($command_params, $valid_method);
        
        $response = new stdClass();
        $response->result = call_user_func_array(array($this->console_application_instance, $valid_method), $related_params);
        
        return $response;
    }

    private function get_related_params($command_params = array(), $valid_method = ''): array
    {
        $related_params = [];

        foreach($this->valid_methods[$valid_method] as $param)
        {
            if(!isset($command_params[$param]))
            {
                throw new Exception("Parameter {$param} not found in the command issued");
            }

            $related_params[] = $command_params[$param];
        }

        return $related_params;
    }

    private function get_valid_method($command_params = array()): string
    {
        $valid_method = '';

        foreach($command_params as $key=>$value)
        {
            if(array_key_exists($key, $this->valid_methods) && !$value)
            {
                $valid_method = $key;
                break;
            }
        }

        return $valid_method;
    }
}