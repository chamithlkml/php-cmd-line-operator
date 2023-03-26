<?php
namespace custom_namespace;

class YourConsoleApp{

    public function subscribe(int $plan_id=0, string $email='', string $first_name='', string $last_name=''): object
    {
        $obj = new \stdClass();
        $obj->email = $email;
        $obj->first_name = $first_name;
        $obj->last_name = $last_name;
        $obj->plan_id = $plan_id;
        $obj->uuid = uniqid();

        return $obj;
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

    private function doSomething(): void
    {

    }

}