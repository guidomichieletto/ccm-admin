<?php
  class InboxEmail{
    private $id;
    public $senderName;
    public $senderEmail;
    public $subject;
    public $body;
    public $time;
    public $readed = 0;

    function __construct($id = null){
      $this->id = $id;

      if(!is_null($id)){
        $data = db()->select('email_inbox')->where('InboxID', $id)->fetchAll()[0];
        $this->senderName = $data['SenderName'];
        $this->senderEmail = $data['SenderEmail'];
        $this->subject = $data['Subject'];
        $this->body = $data['Body'];
        $this->time = $data['Time'];
        $this->readed = $data['Readed'];
      }
    }

    function save(){
      if(is_null($this->id)){
        db()->insert('email_inbox')->params([
          'SenderName' => $this->senderName,
          'SenderEmail' => $this->senderEmail,
          'Subject' => $this->subject,
          'Body' => $this->body,
          'Time' => $this->time,
          'Readed' => $this->readed
        ])->execute();

        $this->id = db()->lastInsertId();

      } else {

        db()->update('email_inbox')->params([
          'SenderName' => $this->senderName,
          'SenderEmail' => $this->senderEmail,
          'Subject' => $this->subject,
          'Body' => $this->body,
          'Time' => $this->time,
          'Readed' => $this->readed
        ])->where('InboxID', $this->id)->execute();
      }
    }

    function getAttachments(){
      $attachments = db()->select('email_inbox_attachments')->where('InboxID', $this->id)->fetchAll();
      $attachmentsobj = array();
      foreach($attachments as $attachment) $attachmentsobj[] = new InboxEmailAttachment($attachment['AttachmentID']);

      return $attachmentsobj;
    }

    /**
     * @return mixed|null
     */
    public function getID(): mixed
    {
      return $this->id;
    }
  }

  class InboxEmailList{
    protected $list;

    function __construct($filters = array()){
      $listobj = array();
      $list = db()->select('email_inbox');
      foreach ($filters as $field => $value){
        if($value != "" && !is_null($value) && $value != "-1") $list = $list->where($field, $value);
      }
      $list = $list->orderBy('Time', 'DESC')->fetchAll();

      foreach($list as $email){
        $listobj[] = new InboxEmail($email['InboxID']);
      }

      $this->list = $listobj;
    }

    function receive(){
      $mailbox = new PhpImap\Mailbox(
        '{' . $GLOBALS['imap']['Server'] . ':' . $GLOBALS['imap']['Port'] . '/imap/' . $GLOBALS['imap']['Security'] . '}INBOX', $GLOBALS['imap']['Username'], $GLOBALS['imap']['Password']
      );

      try {
        $mail_ids = $mailbox->searchMailbox('UNSEEN');
      } catch (PhpImap\Exceptions\ConnectionException $ex) {
        exit('IMAP connection failed: '.$ex->getErrors('first'));
      } catch (Exception $ex) {
        exit('An error occured: '.$ex->getMessage());
      }

      $i = 0;
      foreach ($mail_ids as $mail_id) {
        $email = $mailbox->getMail($mail_id, true);

        $inbox = new InboxEmail();
        $inbox->senderName = $email->fromName;
        $inbox->senderEmail = $email->fromAddress;
        $inbox->subject = $email->subject;
        $inbox->body = is_null($email->textHtml) ? $email->textPlain : $email->textHtml;
        $inbox->time = date('Y-m-d H:i:s', strtotime($email->date));
        $inbox->save();

        if($email->hasAttachments()){
          foreach($email->getAttachments() as $attachment){
            $filename = $inbox->getID() . "_" . bin2hex(random_bytes(18)) . "." . explode('.', $attachment->name)[1];
            $inboxAttachment = new InboxEmailAttachment();
            $inboxAttachment->inboxid = $inbox->getID();
            $inboxAttachment->filename = $filename;
            $inboxAttachment->originalName = $attachment->name;
            $attachment->setFilePath('files/attachments/' . $filename );
            $attachment->saveToDisk();
            $inboxAttachment->save();
          }
        }
        $i++;
      }

      $mailbox->disconnect();

    }

    function getList(){
      return $this->list;
    }
  }