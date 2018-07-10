<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 06/07/18
 * Time: 16:45
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity(fields={"email"},message="already have")
 */
class user implements UserInterface {

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @Assert\NotBlank()
   * @Assert\Email()
   * @ORM\Column(type="string", unique=true)
   */
  private $email;

  /**
   * @ORM\Column(type="string")
   */
  private $password;

  /**
   *  @Assert\NotBlank(groups={"Registration"})
   */
  private $plainPassword;

  /**
   * @ORM\Column(type="json_array")
   */
  private $roles = [];

  public function getUsername() {

    return $this->email;

  }

  public function getRoles() {
    $roles = $this->roles;
    if(!in_array('ROLE_USER',$roles)){
      $roles[]='ROLE_USER';
    }
    return $roles;
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

  /**
   * @param mixed $roles
   */
  public function setRoles($roles) {
    $this->roles = $roles;
  }

  /**
   * @return mixed
   */
  public function getEmail() {
    return $this->email;
  }


}