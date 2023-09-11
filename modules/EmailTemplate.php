<?php
  class EmailTemplate
  {
    private $id;
    public $name;
    public $subject;
    public $body;

    function __construct($id)
    {
      $this->id = $id;

      $data = db()->select('email_templates')->where('TemplateID', $id)->fetchAll()[0];
      $this->name = $data['Name'];
      $this->subject = $data['Subject'];
      $this->body = $data['Body'];

    }

    function fromArray($array){
      foreach ($array as $key => $value){
        $this->$key = $value;
      }
    }

    function save(){
      db()->update('email_templates')->params([
        'Subject' => $this->subject,
        'Body' => $this->body
      ])->where('TemplateID', $this->id)->execute();
    }

    function getID(){
      return $this->id;
    }
  }

  class EmailTemplatesList{
    protected $templates;

    function __construct($hidden = 0){
      $templatesobj = array();
      $templates = db()->select('email_templates')->fetchAll();

      foreach($templates as $template){
        $templatesobj[] = new EmailTemplate($template['TemplateID']);
      }

      $this->templates = $templatesobj;
    }

    function getList(){
      return $this->templates;
    }
  }