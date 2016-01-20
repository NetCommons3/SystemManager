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
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//リクエストセット
		if ($this->request->is('post')) {
			//登録処理
			$this->SiteManager->saveData();

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
				)
			));
		}
	}
}