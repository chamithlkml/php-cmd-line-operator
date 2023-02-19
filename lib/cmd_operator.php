<?php
namespace chamithlkml;

class CmdOperator{

    public function __construct(
        private $console_application_instance=null
    ){}

    public function get_actions(): array
    {
        $class_methods = get_class_methods($this->console_application_instance);
        print_r($class_methods);
        return [];
    }
}