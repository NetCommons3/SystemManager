<?php
/**
 * AuthSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SystemManagerAppController', 'SystemManager.Controller');

/**
 * システム管理【ログイン設定】
 * 外部プラグインの認証設定を行う。
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\SystemManager\Controller
 */
class AuthSettingsController extends SystemManagerAppController {

/**
 * @var array authenticators
 */
	protected $_authenticators = array();

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'SiteManager.SiteSetting',
	);

/**
 * beforeFilter
 *
 * @return void
 * @see SystemManagerHelper::tabs()
 **/
	public function beforeFilter() {
		// SystemManagerHelper::tabs() で、外部認証プラグイン（AuthXXXX）がないと、ログイン設定タブを表示しないため、
		// このコントローラに来てる時点で、$this->_authenticatorsには外部認証プラグインのプラグイン名が１つ以上ある
		$this->_authenticators = $this->_getAuthenticators();
		//$this->set('authenticators', $authenticators);

		$authTabs = $this->_getAuthTabs();
		$this->set('authTabs', $authTabs);

		parent::beforeFilter();
	}

/**
 * Return available authenticators
 *
 * @return array authenticators
 * @see AuthAppController::_getAuthenticators() からコピー
 */
	protected function _getAuthenticators() {
		$authenticators = array();
		$plugins = App::objects('plugins');
		foreach ($plugins as $plugin) {
			// @see https://regexper.com/#%5EAuth(%5BA-Z0-9_%5D%5B%5Cw%5D%2B)
			if (preg_match('/^Auth([A-Z0-9_][\w]+)/', $plugin)) {
				if ($plugin === 'AuthGeneral') {
					// AuthGeneralは含めない
					continue;
				}
				//$authenticators[] = Inflector::underscore($plugin);
				$authenticators[] = $plugin;
			}
		}

		return $authenticators;
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//$this->_prepare();

		//リクエストセット
		if ($this->request->is('post')) {
			$this->set('activeAuthTab', Hash::get($this->request->data['SiteSetting'], 'activeAuthTab', 'auth-general'));

			// * 自動ログアウトする時間(gc_maxlifetime)
			//$this->request->data['SiteSetting']['Session.ini.session.gc_maxlifetime']['0']['value'] =
			//				$this->request->data['SiteSetting']['Session.ini.session.cookie_lifetime']['0']['value'];

			//登録処理
			//$this->SiteManager->saveData();

		} else {
			//var_dump($this->request->query);
			$tagId = strtr(Inflector::underscore($this->_authenticators[0]), '_', '-');
			//$this->set('activeAuthTab', Hash::get($this->request->query, 'activeAuthTab', 'auth-general'));
			$this->set('activeAuthTab', Hash::get($this->request->query, 'activeAuthTab', $tagId));

			// 値を設定
			//			$this->request->data['SiteSetting'] = $this->SiteSetting->getSiteSettingForEdit(
			//				array('SiteSetting.key' => array(
			//					// * 自動ログアウトする時間(cookie_lifetime)(6時間)
			//					'Session.ini.session.cookie_lifetime',
			//					// * 自動ログアウトする時間(gc_maxlifetime)(6時間)
			//					'Session.ini.session.gc_maxlifetime',
			//					// * SSLを有効にする
			//					'Auth.use_ssl',
			//				)
			//			));
		}
	}

/**
 * 前処理
 * 他の認証の設定画面を組み込みについては、後で考える
 *
 * @return array
 */
	protected function _getAuthTabs() {
		//protected function _prepare() {
		$tabs = array();

		//$plugins = App::objects('plugins');

		//foreach ($plugins as $plugin) {
		foreach ($this->_authenticators as $plugin) {
			//			$matches = array();
			//			// @see https://regexper.com/#%5EAuth(%5BA-Z0-9_%5D%5B%5Cw%5D%2B)
			//			if (! preg_match('/^Auth([A-Z0-9_][\w]+)/', $plugin, $matches)) {
			//				continue;
			//			}
			//			if ($plugin === 'AuthGeneral') {
			//				// AuthGeneralは含めない
			//				//continue;
			//			}

			//elementを読み込み設定
			$tagId = strtr(Inflector::underscore($plugin), '_', '-');

			//						if ($plugin === 'AuthGeneral') {
			//							$tabs[$tagId] = array(
			//								'label' => __d('system_manager', 'Auth common setting'),
			//								'element' => 'AuthSettings/auth_form'
			//							);
			//						}
			// $plugin キャメル
			//			var_dump($tagId, $plugin, Inflector::underscore($plugin));
			//			var_dump(Inflector::humanize(Inflector::underscore($plugin)), Inflector::camelize($plugin));

			$tabs[$tagId] = array(
				'label' => __d(Inflector::underscore($plugin), $plugin . '.setting.label'),
				'element' => $plugin . '.setting'
			);
		}
		return $tabs;
		//$this->set('authTabs', $tabs);
	}

}
