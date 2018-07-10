<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 06/07/18
 * Time: 16:45
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class user implements UserInterface {

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", unique=true)
   */
  private $email;

  /**
   * @ORM\Column(type="string")
   */
  private $password;

  private $plainPassword;

  public function getUsername() {

    return $this->email;

  }

  public function getRoles() {
    return ['ROLE_USER'];
  }

  public function getPassword() {
    return $this->password;
  }

  public function getSalt() {

  }

  public function eraseCredentials() {
    $this->plainPassword = NULL;
  }

  /**
   * @param mixed $email
   */
  public function setEmail($email) {
    $this->email = $email;
  }

  /**
   * @param mixed $password
   */
  public function setPassord($password) {
    $this->password = $password;
  }

  /**
   * @return mixed
   */
  public function getPlainPassword() {
    return $this->plainPassword;
  }

  /**
   * @param mixed $plainPassword
   */
  public function setPlainPassword($plainPassword) {
    $this->plainPassword = $plainPassword;
    $this->password = NULL;
  }
}