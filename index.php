<?php

  include "databaseInfo.php";

  class Persona {

    private $name;
    private $lastname;

    public function __construct($name, $lastname) {

      $this->setName($name);
      $this->setLastname($lastname);
    }

    function getName() {

      return $this->name;
    }
    function setName($name) {

      if (strlen($name) > 3) {

        $this->name = $name;
      } else {

        $this->name = -1;
      }
    }

    function getLastname() {

      return $this->lastname;
    }
    function setLastname($lastname) {

      $this->lastname = $lastname;
    }
  }

  class Ospite extends Persona {

    private $dateOfBirth;
    private $documentType;
    private $documentNumber;

    function __construct($name, $lastname, $dateOfBirth, $documentType, $documentNumber) {

      parent::__construct($name, $lastname);

      $this->setDateOfBirth($dateOfBirth);
      $this->setDocumentType($documentType);
      $this->setDocumentNumber($documentNumber);
    }

    function getDateOfBirth() {

      return $this->dateOfBirth;
    }
    function setDateOfBirth($dateOfBirth) {

      $this->dateOfBirth = $dateOfBirth;
    }

    function getDocumentType() {

      return $this->documentType;
    }
    function setDocumentType($documentType) {

      $this->documentType = $documentType;
    }

    function getDocumentNumber() {

      return $this->documentNumber;
    }
    function setDocumentNumber($documentNumber) {

      $this->documentNumber = $documentNumber;
    }

    public static function getAllOspiti($conn) {

      $sql = "
              SELECT *
              FROM ospiti
      ";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $ospiti = [];
        while($row = $result->fetch_assoc()) {
          $ospiti[] =
              new Ospite($row["name"],
                         $row["lastname"],
                         $row["date_of_birth"],
                         $row["document_type"],
                         $row["document_number"]);
        }
      }
      return $ospiti;
    }
  }

  class Pagante extends Persona {

    private $address;

    function __construct($name, $lastname, $address) {

      parent::__construct($name, $lastname);
      $this->setAddress($address);
    }

    function getAddress() {

      return $this->address;
    }
    function setAddress($address) {

      $this->address = $address;
    }

    public static function getAllPaganti($conn) {

      $sql = "
              SELECT *
              FROM paganti
      ";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $paganti = [];
        while($row = $result->fetch_assoc()) {

          $paganti[] = new Pagante($row["name"], $row["lastname"], $row["address"]);
        }
      }
      return $paganti;
    }
  }

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_errno) {

    echo $conn->connect_error;
    return;
  }

  $paganti = Pagante::getAllPaganti($conn);
  $conn->close();

  foreach ($paganti as $pagante) {
    var_dump($pagante); echo "<br><br>";
  }

 ?>
