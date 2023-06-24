<?php
include "../src/Modules/System/UsersController.php"

public function testFindUserById()
{
    $user = new UsersController();
    $this->assertEquals($user->selectByID(1))->rowCount(), 1);
}

public function deleteUserById()
{
    $user = new UsersController();
    $this->assertEquals($user->delete([1])->rowCount(), 1);
}