<?php
class Member{
    private $id;
    public $surname;
    public $name;
    public $sex;
    public $birthDate;
    public $cf;
    public $address;
    public $city;
    public $province;
    public $email;
    public $phone;
    public $cardNr;

    function __construct($id = null){
      $this->id = $id;

      if(!is_null($id)){
        $data = db()->select('members')->where('MemberID', $id)->fetchAll()[0];
        $this->surname = $data['Surname'];
        $this->name = $data['Name'];
        $this->sex = $data['Sex'];
        $this->birthDate = $data['BirthDate'];
        $this->cf = $data['CF'];
        $this->address = $data['Address'];
        $this->city = $data['City'];
        $this->province = $data['Province'];
        $this->email = $data['Email'];
        $this->phone = $data['Phone'];
      }

    }

  function fromArray($array){
    foreach ($array as $key => $value){
      $this->$key = $value;
    }
  }

    function save(){
      if(is_null($this->id)){
        db()->insert('members')->params([
          'Surname' => $this->surname,
          'Name' => $this->name,
          'Sex' => $this->sex,
          'BirthDate' => $this->birthDate,
          'CF' => $this->cf,
          'Address' => $this->address,
          'City' => $this->city,
          'Province' => $this->province,
          'Email' => $this->email,
          'Phone' => $this->phone
        ])->execute();

        $this->id = db()->lastInsertId();

      } else {

        db()->update('members')->params([
          'Surname' => $this->surname,
          'Name' => $this->name,
          'Sex' => $this->sex,
          'BirthDate' => $this->birthDate,
          'CF' => $this->cf,
          'Address' => $this->address,
          'City' => $this->city,
          'Province' => $this->province,
          'Email' => $this->email,
          'Phone' => $this->phone
        ])->where('MemberID', $this->id)->execute();
      }
    }

    function getID(){
      return $this->id;
    }

    function getIDCard(){
      $id = db()->select('idcards')->where('MemberID', $this->id)->orderBy('Expire', 'DESC')->limit(1)->fetchAll();
      if(empty($id)) return null;
      return new IDCard($id[0]['IDCardID']);
    }

    function getMedicalCertificate(){
      $cm = db()->select('medicalcertificates')->where('MemberID', $this->id)->orderBy('Expire', 'DESC')->limit(1)->fetchAll();
      if(empty($cm)) return null;
      return new MedicalCertificate($cm[0]['MedicalCertificateID']);
    }

    function uploadIDCard($file, $expire){
      $ext = explode(".", $file['name'])[1];
      $filename = "CI_" . $this->surname . "_" . $this->name . "_" . bin2hex(random_bytes(18)) . "." . $ext;
      db()->insert('idcards')->params([
        'MemberID' => $this->id,
        'FileName' => $filename,
        'Expire' => $expire
      ])->execute();
      move_uploaded_file($file['tmp_name'], "files/id-cards/" . $filename);
    }

  function uploadMedicalCertificate($file, $expire, $competitive){
    $ext = explode(".", $file['name'])[1];
    $filename = "CM_" . $this->surname . "_" . $this->name . "_" . bin2hex(random_bytes(18)) . "." . $ext;
    db()->insert('medicalcertificates')->params([
      'MemberID' => $this->id,
      'FileName' => $filename,
      'Expire' => $expire,
      'Competitive' => $competitive
    ])->execute();
    move_uploaded_file($file['tmp_name'], "files/medical-certificates/" . $filename);
  }
}

class MemberList{
    protected $members;

    function __construct(){
      $membersobj = array();
      $members = db()->select('members')->orderBy('Surname', 'ASC')->fetchAll();

      foreach($members as $member){
          $membersobj[] = new Member($member['MemberID']);
      }

      $this->members = $membersobj;
    }

    function getList(){
        return $this->members;
    }
}