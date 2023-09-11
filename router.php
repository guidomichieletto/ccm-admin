<?php
  //AUTH
  app()->group('/auth', function(){

    //LOGIN
    app()->get('/login', function(){
      auth()->guard('guest');
      response()->markup(app()->blade->render('auth.login'));
    });

    app()->post('/login', function(){
      $login = auth()->login(['email' => app()->request()->body()['email'], 'password' => hash('sha512', app()->request()->body()['password'])]);

      if($login){
        $user = new User(auth()->user()['UserID']);
        $user->lastLogin = date("Y-m-d H:i:s");
        $user->save();
        response()->redirect($GLOBALS['basePath']);
      } else {
        $errors = auth()->errors();
        response()->markup(app()->blade->make('auth.login', ['email' => app()->request()->body()['email'], 'errors' => $errors])->render());
      }
    });

    //LOST PASSWORD
    app()->get('/forgot-password', function(){
      auth()->guard('guest');
      response()->markup(app()->blade->render('auth.forgot-password'));
    });

    app()->post('/forgot-password', function(){
      auth()->guard('guest');
      $userdb = db()->select('users')->where('Email', app()->request()->body()['email'])->limit(1)->fetchAll()[0];
      if(isset($userdb['UserID'])){
        $user = new User($userdb['UserID']);
        $user->forgotPassword();
      }
      response()->markup(app()->blade->render('auth.forgot-password', ['response' => 'Se l\'indirizzo email è corretto ti abbiamo inviato un messaggio per reimpostare la password']));
    });

    app()->get('/reset-password/{recoveryCode}', function($recoveryCode){
      auth()->guard('guest');
      $userdata = db()->select('users')->where('RecoveryCode', $recoveryCode)->limit(1)->fetchAll();
      if(!isset($userdata[0]['UserID'])){
        response()->redirect($GLOBALS['basePath'] . 'auth/login');
        exit();
      } else $user = new User($userdata[0]['UserID']);
      response()->markup(app()->blade->render('auth.reset-password', ['user' => $user]));
    });

    app()->post('/reset-password/{recoveryCode}', function($recoveryCode){
      auth()->guard('guest');
      $userdata = db()->select('users')->where('RecoveryCode', $recoveryCode)->limit(1)->fetchAll();
      if(!isset($userdata[0]['UserID'])){
        response()->redirect($GLOBALS['basePath'] . 'auth/login');
        exit();
      } else $user = new User($userdata[0]['UserID']);
      $user->changePassword(app()->request()->body()['newPassword']);
      response()->markup(app()->blade->render('auth.reset-password', ['user' => $user, 'response' => 'Password reimpostata correttamente']));
    });

    //LOGOUT
    app()->get('/logout', function(){
      auth()->logout();
      response()->redirect($GLOBALS['basePath'] . "auth/login");
    });

    app()->get('/account-setup/{step}', function($step){
      auth()->guard('auth');
      $authuser = new User(auth()->user()['UserID']);
      response()->markup(app()->blade->render('auth.wizard.step' . $step, ['authUser' => $authuser]));
    });

    app()->post('/account-setup/{step}', function($step){
      auth()->guard('auth');
      $authuser = new User(auth()->user()['UserID']);
      if($step == 2){
        $authuser->email = app()->request()->body()['email'];
        $authuser->save();
        response()->redirect($GLOBALS['basePath'] . "auth/account-setup/3");
      }
      if($step == 3){
        $authuser->changePassword(app()->request()->body()['newPassword']);
        response()->redirect($GLOBALS['basePath'] . "auth/account-setup/4");
      }
      if($step == 4){
        $authuser->confirmed = 1;
        $authuser->save();
        response()->redirect($GLOBALS['basePath']);
      }
    });

  });

  //DASHBOARD
  app()->get('/', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!$authuser->confirmed) {
      response()->redirect($GLOBALS['basePath'] . 'auth/account-setup/1');
      exit();
    }
    $members = new MemberList();
    $materials = new MaterialList();
    $emails = new InboxEmailList(array('Readed' => 0));
    response()->markup(app()->blade->render('dashboard.home', ['authUser' => $authuser, 'alerts' => [], 'members' => $members->getList(), 'materials' => $materials->getList(), 'emails' => $emails->getList()]));
  });

  //ACCOUNT SETTINGS
  app()->get('/account/settings', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    response()->markup(app()->blade->render('dashboard.account-settings', ['authUser' => $authuser, 'alerts' => []]));
  });

  app()->post('/account/settings', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(isset(app()->request()->body()['avatar-img'])) $authuser->setAvatar(request()->files('avatar-img'));
    $authuser->fromArray(app()->request()->body());
    $authuser->save();
    response()->markup(app()->blade->render('dashboard.account-settings', ['authUser' => $authuser, 'alerts' => []]));
  });

  //CHANGELOG
  app()->get('/changelog', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    response()->markup(app()->blade->render('dashboard.changelog', ['authUser' => $authuser, 'alerts' => []]));
  });

  //MEMBERS
  app()->get('/members', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('members_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $members = new MemberList();
    response()->markup(app()->blade->render('dashboard.members', ['authUser' => $authuser, 'alerts' => [], 'members' => $members->getList()]));
  });

  //CREATE NEW MEMBER
  app()->post('/members', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('members_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    //Save new job
    $member = new Member();
    $member->fromArray(app()->request()->body());
    $member->save();

    $members = new MemberList();
    response()->markup(app()->blade->render('dashboard.members', ['authUser' => $authuser, 'alerts' => [], 'members' => $members->getList()]));
  });

  //MEMBER DOWNLOADS

  //ID CARD
  app()->get('/member/{memberid}/identity-card', function($memberid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('members_docs_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    $member = new Member($memberid);
    $id = $member->getIDCard();
    $ext = explode(".", "files/id-cards/" . $id->filename)[1];

    response()->download("files/id-cards/" . $id->filename, "CI_" . $member->surname . "_" . $member->name . "." . $ext);
  });

  //MEDICAL CERT
  app()->get('/member/{memberid}/medical-certificate', function($memberid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('members_docs_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    $member = new Member($memberid);
    $cm = $member->getMedicalCertificate();
    $ext = explode(".", "files/medical-certificates/" . $cm->filename)[1];

    response()->download("files/medical-certificates/" . $cm->filename, "CM_" . $member->surname . "_" . $member->name . "." . $ext);
  });

  //MEMBER UPLOADS

  //ID CARD

  app()->post('/member/{memberid}/identity-card', function($memberid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('members_docs_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    $member = new Member($memberid);
    $member->uploadIDCard(request()->files('file'), request()->body()['expire']);

    response()->redirect($GLOBALS['basePath'] . "member/" . $member->getID());
  });

  app()->post('/member/{memberid}/medical-certificate', function($memberid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('members_docs_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    $member = new Member($memberid);
    $member->uploadMedicalCertificate(request()->files('file'), request()->body()['expire'], request()->body()['competitive']);

    response()->redirect($GLOBALS['basePath'] . "member/" . $member->getID());
  });

  //MEMBER
  app()->get('/member/{memberid}', function($memberid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('members_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    $member = new Member($memberid);

    response()->markup(app()->blade->render('dashboard.member', ['authUser' => $authuser, 'alerts' => [], 'member' => $member]));
  });

  app()->post('/member/{memberid}', function($memberid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('members_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    $member = new Member($memberid);
    $member->fromArray(app()->request()->body());
    $member->save();

    response()->markup(app()->blade->render('dashboard.member', ['authUser' => $authuser, 'alerts' => [], 'member' => $member]));
  });

  //MATERIALS
  app()->get('/materials', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('materials_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $members = new MemberList();
    $materialtypes = new MaterialTypeList();
    $materials = new MaterialList(request()->get(["Name", "MaterialTypeID", "OwnerID"]));
    response()->markup(app()->blade->render('dashboard.materials', ['authUser' => $authuser, 'alerts' => [], 'members' => $members->getList(), 'materialTypes' => $materialtypes->getList(), 'materials' => $materials->getList()]));
  });

  //CREATE NEW MATERIAL
  app()->post('/materials', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('materials_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    //Save new job
    $material = new Material();
    $material->fromArray(app()->request()->body());
    $material->save();

    $members = new MemberList();
    $materialtypes = new MaterialTypeList();
    $materials = new MaterialList();
    response()->markup(app()->blade->render('dashboard.materials', ['authUser' => $authuser, 'alerts' => [], 'members' => $members->getList(), 'materialTypes' => $materialtypes->getList(), 'materials' => $materials->getList()]));
  });

  app()->get('/material/{materialid}', function($materialid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('materials_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    $material = new Material($materialid);
    $materialtypes = new MaterialTypeList();
    $members = new MemberList();

    response()->markup(app()->blade->render('dashboard.material', ['authUser' => $authuser, 'members' => $members->getList(), 'materialTypes' => $materialtypes->getList(), 'alerts' => [], 'material' => $material]));
  });

  app()->post('/material/{materialid}', function($materialid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('materials_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    $members = new MemberList();
    $materialtypes = new MaterialTypeList();
    $material = new Material($materialid);
    $material->fromArray(app()->request()->body());
    $material->save();

    response()->markup(app()->blade->render('dashboard.material', ['authUser' => $authuser, 'members' => $members->getList(), 'materialTypes' => $materialtypes->getList(), 'alerts' => [], 'material' => $material]));
  });

  //USERS
  app()->get('/users', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('users_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    $users = new UserList();
    response()->markup(app()->blade->render('dashboard.users', ['authUser' => $authuser, 'alerts' => [], 'users' => $users->getList()]));
  });

  //NEW USER
  app()->post('/users', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('users_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    //Save new user
    $user = new User();
    $user->fromArray(app()->request()->body());
    $user->save();

    $users = new UserList();
    response()->markup(app()->blade->render('dashboard.users', ['authUser' => $authuser, 'alerts' => [], 'users' => $users->getList()]));
  });

  app()->get('/user/{userid}', function($userid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('users_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    $roles = new RoleList();
    $user = new User($userid);
    response()->markup(app()->blade->render('dashboard.user', ['authUser' => $authuser, 'alerts' => [], 'roles' => $roles->getList(), 'user' => $user]));
  });

  app()->post('/user/{userid}', function($userid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('users_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }

    $roles = new RoleList();
    $user = new User($userid);
    $user->fromArray(app()->request()->body());
    $user->save();
    response()->markup(app()->blade->render('dashboard.user', ['authUser' => $authuser, 'alerts' => [], 'roles' => $roles->getList(), 'user' => $user]));
  });

  //EMAIL

  //INBOX
  app()->get('/email/inbox', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('email_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $emails = new InboxEmailList(request()->get(["Readed"]));
    response()->markup(app()->blade->render('dashboard.email.inbox', ['authUser' => $authuser, 'alerts' => [], 'emails' => $emails->getList()]));
  });

  app()->get('/email/inbox/{inboxid}/attachment/{attachmentid}', function($inboxid, $attachmentid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('email_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $attachment = new InboxEmailAttachment($attachmentid);
    response()->download("files/attachments/" . $attachment->filename, $attachment->originalName);
  });

  app()->get('/email/inbox/{inboxid}', function($inboxid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('email_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $email = new InboxEmail($inboxid);
    $email->readed = 1;
    $email->save();
    response()->markup(app()->blade->render('dashboard.email.inbox-mail', ['authUser' => $authuser, 'alerts' => [], 'email' => $email]));
  });

  //QUEUE
  app()->get('/email/queue', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('email_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $emails = new QueueEmailList;
    response()->markup(app()->blade->render('dashboard.email.queue', ['authUser' => $authuser, 'alerts' => [], 'emails' => $emails->getList()]));
  });

  app()->get('/email/queue/{queueid}/send', function($queueid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('email_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $email = new QueueEmail($queueid);
    $email->send();
    response()->redirect($GLOBALS['basePath'] . 'email/queue');
  });

  app()->get('/email/queue/{queueid}/cancel', function($queueid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('email_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $email = new QueueEmail($queueid);
    $email->deleted = 1;
    $email->save();
    response()->redirect($GLOBALS['basePath'] . 'email/queue');
  });

  app()->get('/email/queue/{queueid}', function($queueid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('email_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $email = new QueueEmail($queueid);
    response()->markup(app()->blade->render('dashboard.email.queue-mail', ['authUser' => $authuser, 'alerts' => [], 'email' => $email]));
  });

  app()->post('/email/queue/{queueid}', function($queueid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('email_view', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $email = new QueueEmail($queueid);
    $email->fromArray(app()->request()->body(false));
    $email->save();
    response()->markup(app()->blade->render('dashboard.email.queue-mail', ['authUser' => $authuser, 'alerts' => [], 'email' => $email]));
  });

  //TEMPLATES
  app()->get('/email/templates', function(){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('email_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $templates = new EmailTemplatesList();
    response()->markup(app()->blade->render('dashboard.email.templates', ['authUser' => $authuser, 'alerts' => [], 'templates' => $templates->getList()]));
  });

  //TEMPLATE
  app()->get('/email/template/{templateid}', function($templateid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('email_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $template = new EmailTemplate($templateid);
    response()->markup(app()->blade->render('dashboard.email.template', ['authUser' => $authuser, 'alerts' => [], 'template' => $template]));
  });

  app()->post('/email/template/{templateid}', function($templateid){
    auth()->guard('auth');
    $authuser = new User(auth()->user()['UserID']);
    if(!in_array('email_edit', $authuser->roles)){
      response()->redirect($GLOBALS['basePath'] . '403');
      exit();
    }
    $template = new EmailTemplate($templateid);
    $template->fromArray(app()->request()->body());
    $template->save();
    response()->markup(app()->blade->render('dashboard.email.template', ['authUser' => $authuser, 'alerts' => [], 'template' => $template]));
  });

  //AJAX API
  app()->group('/ajax', function(){

    //SEND RESET PASSWORD EMAIL ADMIN
    app()->post('/password-reset-email/{userid}', function($userid){
      auth()->guard('auth');
      $authuser = new User(auth()->user()['UserID']);
      if(!in_array('users_edit', $authuser->roles)){
        response()->redirect($GLOBALS['basePath'] . '403');
        exit();
      }
      $user = new User($userid);
      $user->forgotPassword();
      response()->json(array('Response' => "Ok"));
    });

    //CHANGE USER PASSWORD ADMIN
    app()->post('/password-change/{userid}', function($userid){
      auth()->guard('auth');
      $authuser = new User(auth()->user()['UserID']);
      if(!in_array('users_edit', $authuser->roles)){
        response()->redirect($GLOBALS['basePath'] . '403');
        exit();
      }
      $user = new User($userid);
      $response = $user->changePassword(app()->request()->body()['newPassword']);
      response()->json(array('Response' => $response));
    });

    //CHANGE PASSWORD
    app()->post('/password-change', function(){
      auth()->guard('auth');
      $authuser = new User(auth()->user()['UserID']);
      $response = $authuser->changePassword(app()->request()->body()['newPassword'], app()->request()->body()['oldPassword']);
      response()->json(array('Response' => $response));
    });
  });

  //403
  app()->get('/403', function(){
    auth()->guard('auth');
    response()->markup(app()->blade->render('403'), 403);
  });

  //404
  app()->set404(function () {
    response()->markup(app()->blade->render('404'), 404);
  });

  //500
  app()->setErrorHandler(function () {
    response()->markup(app()->blade->render('500'), 500);
  });

  //MAINTAINANCE
  app()->setDown(function () {
    response()->markup(app()->blade->render('maintainance'));
  });

  //CRONJOB
  app()->get('/cronjob', function(){
    $inbox = new InboxEmailList();
    $inbox->receive();
    $queue = new QueueEmailList();
    $queue->send();

    response()->json(array("Response" => "OK"));
  });