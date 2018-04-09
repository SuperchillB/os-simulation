<?php

class User {

  public $db;

  function __construct($db) {
    $this->db = $db;
  }

  function hasAuthorizedAccess($emailUser) {
    /*
    (IN) $emailUser: email of the user we want to test
    (OUT) boolean: True if the user can access / false if not
    */

    try {

      $statement = $this->db->prepare("SELECT emailUser FROM user WHERE emailUser = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()){
        return true;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  function hasAdminRights($emailUser) {
    /*
    (IN) $emailUser: email of the user we want to test
    (OUT) boolean: True if the user has admin rights / false if not
    */

    try {

      $statement = $this->db->prepare("SELECT emailUser, typeUser FROM user WHERE emailUser = :emailUser AND (typeUser LIKE 'coach' OR typeUser LIKE 'staff') LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        return true;
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  function getUserFirstName($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, NULL if a data is found but empty, false if no user was found
    */

    try {

      $statement = $this->db->prepare("SELECT `firstNameUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  function getUserLastName($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, NULL if a data is found but empty, false if no user was found
    */

    try {

      $statement = $this->db->prepare("SELECT `lastNameUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  function getUserMainLanguageCode($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare("SELECT `mainLanguageUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  function getUserMainLanguageName($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare(
        "SELECT  `L`.`nameLanguageEnglish` AS  `information`
         FROM  `user` AS  `U`
         LEFT JOIN  `language` AS  `L` ON  `U`.`mainLanguageUser` =  `L`.`codeLanguage`
         WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  function getUserType($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare("SELECT `typeUser` as `information` FROM `user` WHERE `emailUser` = :emailUser LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  function getUserStartupName($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare(
        "SELECT `C`.`nameClasse` as `information` FROM `user` as `U`
         LEFT JOIN `userClasseRelation` as `UCR` on `U`.`idUser` = `UCR`.`idUser`
         LEFT JOIN `classe` as `C` on `C`.`idClasse` = `UCR`.`idClasse`
         WHERE `U`.`emailUser` = :emailUser
         LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  function getUserStartupId($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) integer if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare(
        "SELECT `UCR`.`idClasse` as `information` FROM `user` as `U`
         LEFT JOIN `userClasseRelation` as `UCR` on `U`.`idUser` = `UCR`.`idUser`
         WHERE `U`.`emailUser` = :emailUser
         LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return intval($row['information']);
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  function getUserImplantationName($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) string if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare(
        "SELECT  `I`.`nameimplantation` AS  `information`
         FROM  `user` AS  `U`
         LEFT JOIN  `userClasseRelation` AS  `UCR` ON  `U`.`idUser` =  `UCR`.`idUser`
         LEFT JOIN  `classeImplantationRelation` AS  `CIR` ON  `CIR`.`idClasse` =  `UCR`.`idClasse`
         LEFT JOIN  `implantation` AS  `I` ON  `CIR`.`idImplantation` =  `I`.`idImplantation`
         WHERE `U`.`emailUser` = :emailUser
         LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row['information'];
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  function getUserImplantationId($emailUser) {
    /*
    (IN) $emailUser: email of the user for which we want to collect the data
    (OUT) integer if a data is found, false if no user was found
    */

    try {

      $statement = $this->db->prepare(
        "SELECT  `CIR`.`idImplantation` AS  `information`
         FROM  `user` AS  `U`
         LEFT JOIN  `userClasseRelation` AS  `UCR` ON  `U`.`idUser` =  `UCR`.`idUser`
         LEFT JOIN  `classeImplantationRelation` AS  `CIR` ON  `CIR`.`idClasse` =  `UCR`.`idClasse`
         WHERE `U`.`emailUser` = :emailUser
         LIMIT 0,1");
      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if($statement->rowCount()) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return intval($row['information']);
      } else {
        return false;
      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

  function getUserInformation($emailUser) {

    try {

      $data = array();

      $statement = $this->db->prepare(
        "SELECT
        `U`.`idUser` as `id`,
        `U`.`firstNameUser` as `firstName`,
        `U`.`lastNameUser` as `lastName` ,
        `U`.`typeUser` as `type`,
        `U`.`mainLanguageUser` as `mainLanguageCode`,
        `L`.`nameLanguageEnglish` as `mainLanguage`

        FROM `user` as `U`
        LEFT JOIN  `language` AS  `L` ON  `U`.`mainLanguageUser` =  `L`.`codeLanguage`

        WHERE `emailUser` = :emailUser LIMIT 0,1");

      $statement->bindParam(':emailUser', $emailUser, PDO::PARAM_STR);
      $statement->execute();

      if( $statement->rowCount() ) {

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        $data['startup']['id'] = $this->getUserStartupId($emailUser);
        $data['startup']['name'] = $this->getUserStartupName($emailUser);
        $data['implantation']['id'] = $this->getUserImplantationId($emailUser);
        $data['implantation']['name'] = $this->getUserImplantationName($emailUser);

        $statement = null;

        $statement = $this->db->prepare(
          "SELECT
          `O`.`keyOption` as `type`,
          `UM`.`keyUserMeta` as `key`,
          `O`.`nameOption` as `name`,
          `UM`.`valueUserMeta` as `value`

           FROM `userMeta` as `UM`
           LEFT JOIN `option` as `O` ON `O`.`valueOption` = `UM`.`keyUserMeta`

           WHERE `UM`.`idUser` = :idUser");

        $statement->bindParam(':idUser', $data['id'], PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() > 0) {
          $data['meta'] = array();
          while ( $en = $statement->fetch(PDO::FETCH_ASSOC) ) {
            array_push($data['meta'], $en);
          }
        }

        return $data;

      } else {

        return false;

      }

    } catch (PDOException $e) {
      print "Error !: " . $e->getMessage() . "<br/>";
      die();
    }

  }

}

?>