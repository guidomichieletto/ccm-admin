<?php
  class Role{
    private $id;
    public $description;
    public $tag;

    function __construct($id){
      $this->id = $id;

      $data = db()->select('roles')->where('RoleID', $id)->fetchAll()[0];
      $this->description = $data['Description'];
      $this->tag = $data['Tag'];

    }

    function fromArray($array){
      foreach ($array as $key => $value){
        $this->$key = $value;
      }
    }

    function getID(){
      return $this->id;
    }
  }

  class RoleList{
    protected $list;

    function __construct(){
      $obj = array();
      $list = db()->select('roles')->fetchAll();

      foreach($list as $role){
        array_push($obj, new Role($role['RoleID']));
      }

      $this->list = $obj;
    }

    function getList(){
      return $this->list;
    }
  }