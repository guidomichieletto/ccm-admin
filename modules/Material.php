<?php
  class Material{
    private $id;
    public $name;
    public $description;
    public $number;
    public $ownerid;
    public $typeid;

    function __construct($id = null){
      $this->id = $id;

      if(!is_null($id)){
        $data = db()->select('materials')->where('MaterialID', $id)->fetchAll()[0];
        $this->name = $data['Name'];
        $this->description = $data['Description'];
        $this->number = $data['Number'];
        $this->ownerid = $data['OwnerID'];
        $this->typeid = $data['MaterialTypeID'];
      }

    }

    function fromArray($array){
      foreach ($array as $key => $value){
        $this->$key = $value;
      }
    }

    function save(){
      if(is_null($this->id)){
        db()->insert('materials')->params([
          'Name' => $this->name,
          'Description' => $this->description,
          'Number' => $this->number,
          'OwnerID' => $this->ownerid,
          'MaterialTypeID' => $this->typeid
        ])->execute();

        $this->id = db()->lastInsertId();

      } else {
        
        db()->update('materials')->params([
          'Name' => $this->name,
          'Description' => $this->description,
          'Number' => $this->number,
          'OwnerID' => $this->ownerid,
          'MaterialTypeID' => $this->typeid
        ])->where('MaterialID', $this->id)->execute();
      }
    }

    function getID(){
      return $this->id;
    }

    function getOwner(){
      if($this->ownerid == 0) return null;
      return new Member($this->ownerid);
    }

    function getType(){
      $type = new MaterialType($this->typeid);
      return $type;
    }
  }

  class MaterialList{
    protected $materials;

    function __construct($filters = []){
      $materialsobj = array();
      $materials = db()->select('materials');
      foreach ($filters as $field => $value){
        if($value != "" && !is_null($value) && $value != "-1") {
          !is_numeric($value) ? $materials = $materials->where($field, "LIKE", "%" . $value . "%") : $materials = $materials->where($field, $value);
        }
      }
      $materials = $materials->fetchAll();

      foreach($materials as $material){
        array_push($materialsobj, new Material($material['MaterialID']));
      }

      $this->materials = $materialsobj;
    }

    function getList(){
      return $this->materials;
    }
  }