<?php
namespace custom_namespace;

class ConsoleApp{

    public function subscribe(int $plan_id=0, string $email='', string $first_name='', string $last_name=''): object
    {
        return new \stdClass();
    }

    public function upgrade(int $plain_id=0, string $email='', string $uuid=''): object
    {
        return new \stdClass();
    }

    public function downgrade(int $plain_id=0, string $email='', string $uuid=''): object
    {
        return new \stdClass();
    }

    public function unsubscribe(string $uuid=''): object
    {
        return new \stdClass();
    }

}