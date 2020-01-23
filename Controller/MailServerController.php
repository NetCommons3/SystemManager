<?php
/**
 * MailServer Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SystemManagerAppController', 'SystemManager.Controller');
App::uses('NetCommonsMail', 'Mails.Utility');

/**
 * システム管理【メール設定】
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SystemManager\Controller
 */
class MailServerController extends SystemManagerAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'SiteManager.SiteSetting',
		'SystemManager.TrialMail',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		//メール通知の場合、NetCommonsMailUtilityをメンバー変数にセットする。Mockであれば、newをしない。
		//テストでMockに差し替えが必要なための処理であるので、カバレッジレポートから除外する。
		//@codeCoverageIgnoreStart
		if ($this->params['action'] === 'trial' &&
				(empty($this->mail) || substr(get_class($this->mail), 0, 4) !== 'Mock')) {
			$this->mail = new NetCommonsMail();
		}
		//@codeCoverageIgnoreEnd
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//リクエストセット
		if ($this->request->is('post')) {
			$url = null;
			if (Hash::get($this->request->data, '_SystemManager.trial')) {
				$url = '/system_manager/mail_server/trial';
			}

			//登録処理
			$this->SiteManager->saveData($url);

		} else {
			$this->request->data['SiteSetting'] = $this->SiteSetting->getSiteSettingForEdit(
				array('SiteSetting.key' => array(
					// * 送信者メールアドレス
					'Mail.from',
					// * 送信者
					'Mail.from_name',
					// * メール形式
					'Mail.messageType',
					// * メール送信方法
					'Mail.transport',
					// ** sendmailへのパス
					'Mail.sendmail',
					// ** SMTPサーバアドレス
					'Mail.smtp.host',
					// ** SMTPポート番号
					'Mail.smtp.port',
					// ** SMTPAuthユーザ名
					'Mail.smtp.user',
					// ** SMTPAuthパスワード
					'Mail.smtp.pass',
					// ** STARTTLS SMTP 拡張
					'Mail.smtp.tls',
				)
			));
		}
	}

/**
 * テスト送信
 *
 * @return void
 */
	public function trial() {
		if ($this->request->is('post')) {
			//入力チェック
			$this->TrialMail->set($this->request->data);
			if ($this->TrialMail->validates()) {
				//メール送信処理
				$this->mail->mailAssignTag->setFixedPhraseSubject($this->request->data['TrialMail']['title']);
				$this->mail->mailAssignTag->setFixedPhraseBody($this->request->data['TrialMail']['body']);
				$this->mail->mailAssignTag->initPlugin(Current::read('Language.id'));

				//$this->mail->setReplyTo($this->request->data['TrialMail']['reply_to']);
				$this->mail->initPlugin(Current::read('Language.id'));

				$this->mail->to($this->request->data['TrialMail']['to_address']);
				try {
					$this->mail->setFrom(Current::read('Language.id'));
					if (! $this->mail->sendMailDirect()) {
						return $this->NetCommons->handleValidationError(array('SendMail Error'));
					}
				} catch (Exception $ex) {
					//設定エラーでリダイレクト
					CakeLog::error($ex);
					$this->NetCommons->handleValidationError(
						array('SendMail Error'),
						__d('mails', 'There is errors in the mail settings. It was not able to send mail.')
					);
					return $this->redirect('/system_manager/mail_server/edit');
				}

				//リダイレクト
				$this->NetCommons->setFlashNotification(
					__d('user_manager', 'Successfully mail send.'), array('class' => 'success')
				);
				return $this->redirect('/system_manager/mail_server/edit');
			}
			$this->NetCommons->handleValidationError($this->TrialMail->validationErrors);

		} else {
			$this->request->data['TrialMail']['title'] = __d('system_manager', 'Mail title');
			$this->request->data['TrialMail']['body'] = __d('system_manager', 'Mail body');
			//$this->request->data['TrialMail']['reply_to'] = SiteSettingUtil::read('Mail.from');

			$user = $this->Session->read('Auth');
			$this->request->data['TrialMail']['to_address'] = $user['User']['email'];
		}
	}
}
