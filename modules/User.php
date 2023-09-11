<?php
  class User{
    private $id;
    public $email;
    public $surname;
    public $name;
    public $sex;
    public $role = 0;
    public $avatar = null;
    public $enabled = 1;
    public $confirmed = 0;
    public $created;
    public $lastLogin;
    public $recoveryCode;
    public $roles = array();

    function __construct($id = null){
      $this->id = $id;

      if(!is_null($id)){
        $data = db()->select('users')->where('UserID', $id)->fetchAll()[0];
        $this->email = $data['Email'];
        $this->surname = $data['Surname'];
        $this->name = $data['Name'];
        $this->sex = $data['Sex'];
        $this->role = $data['Role'];
        $this->avatar = $data['Avatar'];
        $this->enabled = $data['Enabled'];
        $this->confirmed = $data['Confirmed'];
        $this->created = $data['Created'];
        $this->lastLogin = $data['LastLogin'];
        $this->recoveryCode = $data['RecoveryCode'];

        $roles = db()->select('userroles', 'RoleTag')->where('UserID', $this->id)->fetchAll();
        foreach($roles as $role){
          $this->roles[] = $role['RoleTag'];
        }
      }

    }

    function fromArray($array){
      foreach ($array as $key => $value){
          $this->$key = $value;
      }
    }

    function save(){
      if(is_null($this->id)){
        db()->insert('users')->params([
          'Email' => $this->email,
          'Surname' => $this->surname,
          'Name' => $this->name,
          'Sex' => $this->sex,
          'Role' => $this->role,
          'Avatar' => $this->avatar,
          'Enabled' => $this->enabled,
          'Confirmed' => $this->confirmed,
          'LastLogin' => $this->lastLogin,
          'RecoveryCode' => $this->recoveryCode
        ])->execute();

        $this->id = db()->lastInsertId();

        $this->changePassword($this->email);
        $this->welcomeEmail();

      } else {
        
        db()->update('users')->params([
          'Email' => $this->email,
          'Surname' => $this->surname,
          'Name' => $this->name,
          'Sex' => $this->sex,
          'Role' => $this->role,
          'Avatar' => $this->avatar,
          'Enabled' => $this->enabled,
          'Confirmed' => $this->confirmed,
          'Created' => $this->created,
          'LastLogin' => $this->lastLogin,
          'RecoveryCode' => $this->recoveryCode
        ])->where('UserID', $this->id)->execute();
      }

      db()->delete('userroles')->where('UserID', $this->id)->execute();

      foreach($this->roles as $role){
        db()->insert('userroles')->params(['UserID' => $this->id, 'RoleTag' => $role])->execute();
      }
    }

    function setAvatar($file){
      $ext = explode(".", $file['name'])[1];
      $filename = $this->id . "_" . bin2hex(random_bytes(18)) . "." . $ext;
      $this->avatar = $filename;
      move_uploaded_file($file['tmp_name'], "static/avatars/" . $filename);
    }

    function changePassword($newPassword, $oldPassword = null){
      if(!is_null($oldPassword)){
        if(db()->select('users')->where('UserID', $this->id)->fetchAll()[0]['Password'] != hash('sha512', $oldPassword))
          return array("level" => "danger", "text" => "La vecchia password non è corretta!");
      }
      db()->update('users')->params(['Password' => hash('sha512', $newPassword)])->where('UserID', $this->id)->execute();
      return array("level" => "success", "text" => "Password cambiata!");
    }

    function forgotPassword(){
      $template = new EmailTemplate(4);
      $email = new QueueEmail();

      $this->recoveryCode = bin2hex(random_bytes(18));
      $this->save();

      $email->recipientName = $this->name . " " . $this->surname;
      $email->recipientEmail = $this->email;
      $email->subject = $template->subject;
      $email->sendDate = date('Y-m-d');
      $email->body = $template->body;
      $email->renderBody(['info' => $this, 'recoveryLink' => $GLOBALS['baseUrl'] . "auth/reset-password/" . $this->recoveryCode]);

      $email->save();
      $email->send();
    }

    function welcomeEmail(){
      $template = new EmailTemplate(3);
      $email = new QueueEmail();

      $email->recipientName = $this->name . " " . $this->surname;
      $email->recipientEmail = $this->email;
      $email->subject = $template->subject;
      $email->sendDate = date('Y-m-d');
      $email->body = $template->body;
      $email->renderBody(['info' => $this]);

      $email->save();
      $email->send();
    }

    function getID(){
      return $this->id;
    }
  }

  class UserList{
    protected $users;

    function __construct(){
      $usersobj = array();
      $users = db()->select('users')->orderBy('Surname', 'ASC')->fetchAll();

      foreach($users as $user){
        array_push($usersobj, new User($user['UserID']));
      }

      $this->users = $usersobj;
    }

    function getList(){
      return $this->users;
    }
  }