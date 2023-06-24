<?php
include "../src/Modules/Pgestao/StaffController.php"

public function testFindStaffById()
{
    $staff = new StaffController();
    $this->assertEquals($staff->selectByID(1))->rowCount(), 1);
}

public function deleteStaffById()
{
    $staff = new StaffController();
    $this->assertEquals($staff->delete([1])->rowCount(), 1);
}

public function deleteStaffByIdNull()
{
    $staff = new StaffController();
    $this->assertEquals($staff->delete([1])->rowCount(), 0);
}