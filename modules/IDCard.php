<?php
  class IDCard
  {
    private $id;
    public $memberid;
    public $filename;
    public $expire;

    function __construct($id = null)
    {
      $this->id = $id;

      if (!is_null($id)) {
        $data = db()->select('idcards')->where('IDCardID', $id)->fetchAll()[0];
        $this->memberid = $data['MemberID'];
        $this->filename = $data['FileName'];
        $this->expire = $data['Expire'];
      }

    }

    function save()
    {
      if (is_null($this->id)) {
        db()->insert('idcards')->params([
          'MemberID' => $this->memberid,
          'FileName' => $this->filename,
          'Expire' => $this->expire
        ])->execute();

        $this->id = db()->lastInsertId();

      } else {

        db()->update('idcards')->params([
          'MemberID' => $this->memberid,
          'FileName' => $this->filename,
          'Expire' => $this->expire
        ])->where('IDCardID', $this->id)->execute();
      }
    }

    function createExpireMail(){
      $template = new EmailTemplate(2);
      $email = new QueueEmail();
      $member = new Member($this->memberid);

      $email->recipientName = $member->name . " " . $member->surname;
      $email->recipientEmail = $member->email;
      $email->subject = $template->subject;
      $email->sendDate = date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));
      $email->body = $template->body;
      $email->renderBody(['info' => $this]);

      $email->save();
    }
  }