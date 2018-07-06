<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 06/07/18
 * Time: 16:45
 */

namespace AppBundle\Entity;


use Symfony\Component\Security\Core\User\UserInterface;

class user implements UserInterface {

  public function getUsername() {
    // TODO: Implement getUsername() method.
  }

  public function getRoles() {
    // TODO: Implement getRoles() method.
  }

  public function getPassword() {
    // TODO: Implement getPassword() method.
  }

  public function getSalt() {
    // TODO: Implement getSalt() method.
  }

  public function eraseCredentials() {
    // TODO: Implement eraseCredentials() method.
  }

}