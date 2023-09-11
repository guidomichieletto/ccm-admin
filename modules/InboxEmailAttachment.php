<?php
  class InboxEmailAttachment{
    private $id;
    public $inboxid;
    public $filename;
    public $originalName;

    function __construct($id = null){
      $this->id = $id;

      if(!is_null($id)){
        $data = db()->select('email_inbox_attachments')->where('AttachmentID', $id)->fetchAll()[0];
        $this->inboxid = $data['InboxID'];
        $this->filename = $data['FileName'];
        $this->originalName = $data['OriginalName'];
      }
    }

    function save(){
      if(is_null($this->id)){
        db()->insert('email_inbox_attachments')->params([
          'InboxID' => $this->inboxid,
          'FileName' => $this->filename,
          'OriginalName' => $this->originalName
        ])->execute();

        $this->id = db()->lastInsertId();

      } else {

        db()->update('email_inbox_attachments')->params([
          'InboxID' => $this->inboxid,
          'FileName' => $this->filename,
          'OriginalName' => $this->originalName
        ])->where('AttachmentID', $this->id)->execute();
      }
    }

    /**
     * @return mixed|null
     */
    public function getId(): mixed
    {
      return $this->id;
    }
  }