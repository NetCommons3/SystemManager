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
 * ログイン・ログアウトの設定を行う。
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
		$this->_prepare();

		//リクエストセット
		if ($this->request->is('post')) {
			$this->set('activeAuthTab', Hash::get($this->request->data['SiteSetting'], 'activeAuthTab', 'auth-general'));

			// * 自動ログアウトする時間(gc_maxlifetime)
			$this->request->data['SiteSetting']['Session.ini.session.gc_maxlifetime']['0']['value'] =
							$this->request->data['SiteSetting']['Session.ini.session.cookie_lifetime']['0']['value'];

			//登録処理
			$this->SiteManager->saveData();

		} else {
			$this->set('activeAuthTab', Hash::get($this->request->query, 'activeAuthTab', 'auth-general'));

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


	}

/**
 * 前処理
 * 他の認証の設定画面を組み込みについては、後で考える
 *
 * @return array tabs
 */
	protected function _prepare() {
		$tabs = array();

		$plugins = App::objects('plugins');
		foreach ($plugins as $plugin) {
			$matches = array();
			if (! preg_match('/^Auth([A-Z0-9_][\w]+)/', $plugin, $matches)) {
				continue;
			}

			//elementを読み込み設定
			$tagId = strtr(Inflector::underscore($plugin), '_', '-');
			if ($plugin === 'AuthGeneral') {
				$tabs[$tagId] = array(
					'label' => __d('system_manager', 'Auth common setting'),
					'element' => 'AuthSettings/auth_form'
				);
			}
		}

		$this->set('authTabs', $tabs);
	}

}
