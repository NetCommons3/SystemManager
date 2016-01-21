<?php
/**
 * AuthSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SystemManagerAppController', 'SystemManager.Controller');

/**
 * システム管理【認証設定】
 *
 * ログイン・ログアウトの設定を行う。
 *
 * 通常のログインとは別の認証システム(LDAPやShibbolethなど)の設定は、
 * AuthXxxxx/View/Elements/auth_setting.ctpファイルを作成することで自動的に読み込む。
 * また、site_settingsテーブル以外に登録する際は、AuthXxxxxSettingにsaveSetting()を作成して下さい。
 *
 * #### サンプルコード
 * ##### AuthLdapSetting
 * ```
 *
 * ```
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SystemManager\Controller
 */
class AuthSettingsController extends SystemManagerAppController {

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

		} else {
			$this->request->data['SiteSetting'] = $this->SiteSetting->getSiteSettingForEdit(
				array('SiteSetting.key' => array(
					// * 自動ログアウトする時間(cookie_lifetime)(6時間)
					'Session.ini.session.cookie_lifetime',
					// * 自動ログアウトする時間(gc_maxlifetime)(6時間)
					'Session.ini.session.gc_maxlifetime',
					// * SSLを有効にする
					'Auth.use_ssl',
				)
			));
		}

		$this->set('authenticators', $this->getAuthenticators());
	}

/**
 * 各ログインプラグインを取得する
 *
 * @return array authenticators
 */
	public function getAuthenticators() {
		$authenticators = array();
		$plugins = App::objects('plugins');
		$matches = array();
		foreach ($plugins as $plugin) {
			if ($plugin === 'AuthGeneral') {
				continue;
			}
			if (preg_match('/^Auth([A-Z0-9_][\w]+)/', $plugin, $matches)) {
				$authenticators[$plugin] = $matches[1];
			}
		}

		return $authenticators;
	}

}
