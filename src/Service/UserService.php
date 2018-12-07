<?php

namespace App\Service;

use App\Repository\UserRepository;



final class UserService {

    private $userRepository;

    public function __construct(UserRepository $userRepository) {

        $this->userRepository = $userRepository;
    }

}

?>