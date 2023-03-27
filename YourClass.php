<?php
namespace CustomNamespace;

class YourClass{

    public function subscribe(int $planId = 0, string $email = '', string $firstName = '', string $lastName = ''): object
    {
        $obj = new \stdClass();
        $obj->email = $email;
        $obj->first_name = $firstName;
        $obj->last_name = $lastName;
        $obj->plan_id = $planId;
        $obj->uuid = uniqid();

        return $obj;
    }

    public function upgrade(int $plainId = 0, string $email = '', string $uuid = ''): object
    {
        return new \stdClass();
    }

    public function downgrade(int $plainId = 0, string $email = '', string $uuid = ''): object
    {
        return new \stdClass();
    }

    public function unsubscribe(string $uuid = ''): object
    {
        return new \stdClass();
    }

    private function doSomething(): void
    {

    }

}