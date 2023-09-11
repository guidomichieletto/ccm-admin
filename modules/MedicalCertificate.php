<?php
  use Illuminate\Support\Facades\Blade;

  class MedicalCertificate
  {
    private $id;
    public $memberid;
    public $filename;
    public $expire;
    public $competitive;

    function __construct($id = null)
    {
      $this->id = $id;

      if (!is_null($id)) {
        $data = db()->select('medicalcertificates')->where('MedicalCertificateID', $id)->fetchAll()[0];
        $this->memberid = $data['MemberID'];
        $this->filename = $data['FileName'];
        $this->expire = $data['Expire'];
        $this->competitive = $data['Competitive'];
      }

    }

    function save()
    {
      if (is_null($this->id)) {
        db()->insert('medicalcertificates')->params([
          'MemberID' => $this->memberid,
          'FileName' => $this->filename,
          'Expire' => $this->expire,
          'Competitive' => $this->competitive
        ])->execute();

        $this->id = db()->lastInsertId();

      } else {

        db()->update('medicalcertificates')->params([
          'MemberID' => $this->memberid,
          'FileName' => $this->filename,
          'Expire' => $this->expire,
          'Competitive' => $this->competitive
        ])->where('MedicalCertificateID', $this->id)->execute();
      }
    }

    function getMember(){
      return new Member($this->memberid);
    }

    function createExpireMail(){
      $template = new EmailTemplate(1);
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