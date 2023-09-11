<?php
  class MemberType{
    private $id;
    public $name;
    public $enabled;

    function __construct($id = null){
      $this->id = $id;

      if(!is_null($id)){
        $data = db()->select('membertypes')->where('MemberTypeID', $id)->fetchAll()[0];
        $this->name = $data['Name'];
        $this->enabled = $data['Enabled'];
      }

    }

    function save(){
      if(is_null($this->id)){
        db()->insert('membertypes')->params([
          'Name' => $this->name,
          'Enabled' => $this->enabled
        ])->execute();

        $this->id = db()->lastInsertId();

      } else {

        db()->update('membertypes')->params([
          'Name' => $this->name,
          'Enabled' => $this->enabled
        ])->where('MemberTypeID', $this->id)->execute();
      }
    }
  }

  class MemberTypeList{
    private $list;
  }