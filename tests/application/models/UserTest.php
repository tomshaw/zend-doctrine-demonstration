<?php

class UserTest extends Zend_Test_PHPUnit_ControllerTestCase
{
	
	public function testCanTest()
	{
		$this->assertTrue(true);
	}
	
    public function testCanCreateUser()
    {
        $user = new Model_User();
        $user->email = "tom@tomshaw.info";
        $user->password = md5(rand(6,6));
        $user->save();

        $this->assertTrue(intval($user->id) == true);
        
        $user->delete();
    }
    
    public function testCanCreateContact()
    {
        $user = new Model_User();
        $user->email = "joann@tomshaw.info";
        $user->password = md5(rand(6,6));     
		$user->Contact->first_name = 'Joann';
		$user->Contact->last_name = 'Shaw';
		$user->Contact->phone = '555-555-5555';
		$user->Contact->address = '2434 At Home Rd.';
		$user->save();

        $this->assertTrue(intval($user->id) == true);
    }
    
    public function testCanCreateComments()
    {
        $user = new Model_User(); 
        $user->email = "bill@tomshaw.info";
        $user->password = md5(rand(6,6));           
		$user->Contact->first_name = 'Bill';
		$user->Contact->last_name = 'Shaw';
		$user->Contact->phone = '555-555-5555';
		$user->Contact->address = '2434 At Home Rd.';
		$user->Comment[0]->comment = 'This is the first comment...';	
		$user->Comment[1]->comment = 'This is the second comment...';
		$user->save();

        $this->assertTrue(intval($user->id) == true);
    }
    
    public function testCanCreateGroups()
    {
        $user = new Model_User(); 
        $user->email = "mary@tomshaw.info";
        $user->password = md5(rand(6,6));           
		$user->Contact->first_name = 'Mary';
		$user->Contact->last_name = 'Shaw';
		$user->Contact->phone = '555-555-5555';
		$user->Contact->address = '2434 At Home Rd.';
		$user->Comment[0]->comment = 'This is the first comment...';	
		$user->Comment[1]->comment = 'This is the second comment...';
		$user->UserGroups[0]->group_id = 1;
		$user->UserGroups[1]->group_id = 2;
		$user->save();

        $this->assertTrue(intval($user->id) == true);
        
        $user = new Model_User(); 
        $user->email = "edward@tomshaw.info";
        $user->password = md5(rand(6,6));           
		$user->Contact->first_name = 'Edward';
		$user->Contact->last_name = 'Shaw';
		$user->Contact->phone = '555-555-5555';
		$user->Contact->address = '2434 At Home Rd.';
		$user->Comment[0]->comment = 'This is the first comment...';	
		$user->Comment[1]->comment = 'This is the second comment...';
		$user->UserGroups[0]->group_id = 3;
		$user->UserGroups[1]->group_id = 4;
		$user->save();

        $this->assertTrue(intval($user->id) == true);
    }

}

