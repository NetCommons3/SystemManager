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
App::uses('AuthenticatorPlugin', 'Auth.Utility');

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
		$authTabs = $this->_getAuthTabs();
		$this->set('authTabs', $authTabs);

		parent::beforeFilter();
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		// [まだ] 外部プラグインでeditを動かしたい
		//$this->_prepare();
		$authExternalPlugins = AuthenticatorPlugin::getExternals();
		// [まだ] $tagIdは、初期表示は[0], 更新したらそのAuthXXXXを指定したい
		$tagId = strtr(Inflector::underscore($authExternalPlugins[0]), '_', '-');

		//リクエストセット
		if ($this->request->is('post')) {
			//$this->set('activeAuthTab', Hash::get($this->request->data['SiteSetting'], 'activeAuthTab', 'auth-general'));
			$this->set('activeAuthTab',
				Hash::get($this->request->data['SiteSetting'], 'activeAuthTab', $tagId));

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
					//ログイン設定
					// * shibbolethログイン
					// ** ウェブサーバに設定したShibboleth認証のロケーション
					'AuthShibboleth.auth_type_shibbloth_location',
					// ** IdPによる個人識別番号に利用する項目
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
					// *** DiscpFeed URL
					'AuthShibboleth.wayf_discofeed_url',
					// *** 他のフェデレーションのIdPを追加する
					'AuthShibboleth.wayf_additional_idps',
				)
			));
		}
	}

/**
 * 外部認証プラグインのタブを取得
 *
 * @return array
 */
	protected function _getAuthTabs() {
		//protected function _prepare() {
		$tabs = array();
		$authExternalPlugins = AuthenticatorPlugin::getExternals();

		foreach ($authExternalPlugins as $plugin) {
			//elementを読み込み設定
			$tagId = strtr(Inflector::underscore($plugin), '_', '-');
			$tabs[$tagId] = array(
				'label' => __d(Inflector::underscore($plugin), $plugin . '.setting.label'),
				'element' => $plugin . '.setting'
			);
		}
		return $tabs;
	}

}
