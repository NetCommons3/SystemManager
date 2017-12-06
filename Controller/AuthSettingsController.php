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
		// [まだ] 外部プラグインでeditを動かしたい
		//$this->_prepare();
		$tagId = strtr(Inflector::underscore($this->_authenticators[0]), '_', '-');

		//リクエストセット
		if ($this->request->is('post')) {
			// [まだ] 必須チェック
			//$this->set('activeAuthTab', Hash::get($this->request->data['SiteSetting'], 'activeAuthTab', 'auth-general'));
			$this->set('activeAuthTab', Hash::get($this->request->data['SiteSetting'], 'activeAuthTab', $tagId));

			// * 自動ログアウトする時間(gc_maxlifetime)
			//$this->request->data['SiteSetting']['Session.ini.session.gc_maxlifetime']['0']['value'] =
			//				$this->request->data['SiteSetting']['Session.ini.session.cookie_lifetime']['0']['value'];

			// [まだ] 保存すると空の1行が余計に登録される
			//登録処理
			$this->SiteManager->saveData();

		} else {
			//var_dump($this->request->query);
			//$this->set('activeAuthTab', Hash::get($this->request->query, 'activeAuthTab', 'auth-general'));
			$this->set('activeAuthTab', Hash::get($this->request->query, 'activeAuthTab', $tagId));

			// 値を設定
			$this->request->data['SiteSetting'] = $this->SiteSetting->getSiteSettingForEdit(
				array('SiteSetting.key' => array(
					'App.default_timezone',
					//ログイン設定
					// * shibbolethログイン
					// ** ウェブサーバに設定したShibboleth認証のロケーション
					'AuthShibboleth.auth_type_shibbloth_location',
					// ** IdPによる個人識別番号
					'AuthShibboleth.idp_userid',
					// ** 学認 Embedded DS
					// *** WAYF URL
					'AuthShibboleth.wayf_URL',
					// *** エンティティID
					'AuthShibboleth.wayf_sp_entityID',
					// *** Shibboleth SPのハンドラURL
					'AuthShibboleth.wayf_sp_handlerURL',
					// *** 認証後に開くURL
					'AuthShibboleth.wayf_return_url',
					// *** ログインしたままにする にチェックを入れて操作させない
					'AuthShibboleth.wayf_force_remember_for_session',
					// *** 表示IdP絞り込みDiscpFeed URL
					'AuthShibboleth.wayf_discofeed_url',
					// *** 他のフェデレーションのIdPを追加する
					'AuthShibboleth.wayf_additional_idps',
				)
			));
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
