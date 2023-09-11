<?php
  class MaterialType{
    private $id;
    public $name;
    public $enabled;

    function __construct($id = null){
      $this->id = $id;

      if(!is_null($id)){
        $data = db()->select('materialtypes')->where('MaterialTypeID', $id)->fetchAll()[0];
        $this->name = $data['Name'];
        $this->enabled = $data['Enabled'];
      }

    }

    function save(){
      if(is_null($this->id)){
        db()->insert('materialtypes')->params([
          'Name' => $this->name,
          'Enabled' => $this->enabled
        ])->execute();

        $this->id = db()->lastInsertId();

      } else {
        
        db()->update('materialtypes')->params([
          'Name' => $this->name,
          'Enabled' => $this->enabled
        ])->where('MaterialTypeID', $this->id)->execute();
      }
    }

    function getID(){
      return $this->id;
    }
  }

  class MaterialTypeList{
    private $types;

    function __construct($enabled = 1){
      $typesobj = array();
      $types = db()->select('materialtypes')->where('Enabled', '>=', $enabled)->fetchAll();

      foreach($types as $type){
        $typesobj[] = new MaterialType($type['MaterialTypeID']);
      }

      $this->types = $typesobj;
    }

    function getList(){
      return $this->types;
    }
  }