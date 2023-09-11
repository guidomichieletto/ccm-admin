<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  class QueueEmail{
    private $id;
    public $senderName = "";
    public $senderEmail = "";
    public $recipientName;
    public $recipientEmail;
    public $subject;
    public $body;
    public $sendDate;
    public $sended = 0;
    public $deleted = 0;
    public $status = "";

    function __construct($id = null){
      $this->id = $id;

      if(!is_null($id)){
        $data = db()->select('email_queue')->where('QueueID', $id)->fetchAll()[0];
        $this->senderName = $data['SenderName'];
        $this->senderEmail = $data['SenderEmail'];
        $this->recipientName = $data['RecipientName'];
        $this->recipientEmail = $data['RecipientEmail'];
        $this->subject = $data['Subject'];
        $this->body = $data['Body'];
        $this->sendDate = $data['SendDate'];
        $this->sended = $data['Sended'];
        $this->deleted = $data['Deleted'];
        $this->status = $data['Status'];
      }
    }

    function fromArray($array){
      foreach ($array as $key => $value){
        $this->$key = $value;
      }
    }

    function save(){
      if(is_null($this->id)){
        db()->insert('email_queue')->params([
          'SenderName' => $this->senderName,
          'SenderEmail' => $this->senderEmail,
          'RecipientName' => $this->recipientName,
          'RecipientEmail' => $this->recipientEmail,
          'Subject' => $this->subject,
          'Body' => $this->body,
          'SendDate' => $this->sendDate,
          'Sended' => $this->sended,
          'Deleted' => $this->deleted,
          'Status' => $this->status
        ])->execute();

        $this->id = db()->lastInsertId();

      } else {

        db()->update('email_queue')->params([
          'SenderName' => $this->senderName,
          'SenderEmail' => $this->senderEmail,
          'RecipientName' => $this->recipientName,
          'RecipientEmail' => $this->recipientEmail,
          'Subject' => $this->subject,
          'Body' => $this->body,
          'SendDate' => $this->sendDate,
          'Sended' => $this->sended,
          'Deleted' => $this->deleted,
          'Status' => $this->status
        ])->where('QueueID', $this->id)->execute();
      }
    }

    function send(){
      $mail = new PHPMailer(true);

      try{
        //Server settings
        $mail->isSMTP();
        $mail->Host       = $GLOBALS['sender']['Server'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $GLOBALS['sender']['Username'];
        $mail->Password   = $GLOBALS['sender']['Password'];
        $mail->SMTPSecure = $GLOBALS['sender']['Security'];
        $mail->Port       = $GLOBALS['sender']['Port'];

        //Recipients
        $mail->setFrom($GLOBALS['sender']['SenderEmail'], $GLOBALS['sender']['SenderName']);
        $mail->addAddress($this->recipientEmail, $this->recipientName);
        $mail->addReplyTo($GLOBALS['sender']['ReplyToEmail'], $GLOBALS['sender']['ReplyToName']);
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Content
        $mail->isHTML(true);
        $mail->Subject = $this->subject;
        $mail->Body    = $this->body;
        //$mail->AltBody = ;

        if (!$mail->send()) {
          db()->update('email_queue')->params([
            'Status' => $mail->ErrorInfo
          ])->where('QueueID', $this->id)->execute();
        } else {
          db()->update('email_queue')->params([
            'Sended' => 1
          ])->where('QueueID', $this->id)->execute();
        }
      } catch (Exception $e){
        db()->update('email_queue')->params([
          'Status' => $mail->ErrorInfo
        ])->where('QueueID', $this->id)->execute();
      }
    }

    function renderBody($args = array()){
      $tmpName = bin2hex(random_bytes(18));
      $file = fopen("templates/tmp/" . $tmpName . ".blade.php", "w");
      fwrite($file, htmlspecialchars_decode($this->body));
      fclose($file);
      $this->body = app()->blade->render('tmp.' . $tmpName, $args);
      unlink("templates/tmp/" . $tmpName . ".blade.php");
    }

    /**
     * @return mixed|null
     */
    public function getID(): mixed
    {
      return $this->id;
    }
  }

  class QueueEmailList{
    protected $list;

    function __construct(){
      $listobj = array();
      $list = db()->select('email_queue')->orderBy('SendDate', 'DESC')->fetchAll();

      foreach($list as $email){
        $listobj[] = new QueueEmail($email['QueueID']);
      }

      $this->list = $listobj;
    }

    function getList(){
      return $this->list;
    }

    function send(){
      $emails = db()->select('email_queue')->where('SendDate', '<=', 'NOW()')->where('Sended', '0')->where('Deleted', '0')->where('Status', '')->fetchAll();

      foreach ($emails as $email){
        $emailobj = new QueueEmail($email['QueueID']);
        $emailobj->send();
      }
    }
  }