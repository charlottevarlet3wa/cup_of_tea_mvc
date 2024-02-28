<?php

require_once 'models/User.php';
require_once 'models/UserManager.php';

require_once 'models/Order.php';
require_once 'models/OrderManager.php';

class TestController {
    public function echoTest(){
        echo "TESTE MOI CE PHP DE SES MOOOOOOORTS";
    }    

    public function phpTest(){
        echo "Hello";
        $manager = new UserManager();
        $manager->addUser("uzumaki", "naruto", "naruto@uzumaki.fr", "password");
    }

    public function setStatus($isStatus){
        // echo "status : " . $isStatus;
        $manager = new OrderManager();
        $manager->updateStatus(2, $isStatus);
    }
}