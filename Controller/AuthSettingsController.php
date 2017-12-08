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
 * use model
 *
 * @var array
 */
	public $uses = array(
		'SiteManager.SiteSetting',
	);

/**
 * Other components
 *
 * @var array
 */
	public $components = array(
		'Auth.AuthPlugin',
	);

/**
 * beforeFilter
 *
 * @return void
 * @see SystemManagerHelper::tabs()
 **/
	public function beforeFilter() {
		$this->set('authTabs', $this->_getAuthTabs());
		$this->set('activeAuthTab', $this->_getActiveAuthTab());

		parent::beforeFilter();
	}

/**
 * 外部認証プラグインのタブを取得
 *
 * @return array
 */
	protected function _getAuthTabs() {
		$tabs = array();
		$authExternalPlugins = $this->AuthPlugin->getExternals();

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

/**
 * get active auth tab
 *
 * @return string
 */
	protected function _getActiveAuthTab() {
		$authExternalPlugins = $this->AuthPlugin->getExternals();
		$initTagId = strtr(Inflector::underscore($authExternalPlugins[0]), '_', '-');

		if ($this->request->is('post')) {
			$activeAuthTab = Hash::get($this->request->data['SiteSetting'], 'activeAuthTab', $initTagId);
		} else {
			$activeAuthTab = Hash::get($this->request->query, 'activeAuthTab', $initTagId);
		}
		return $activeAuthTab;
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$plugin = $this->_getActiveAuthTab();
		// プラグイン名(キャメル)に変更
		$plugin = strtr($plugin, '-', '_');
		$plugin = Inflector::camelize($plugin);
		// AuthXXXX.AuthXXXXSetting
		$pluginComponent = $plugin . '.' . $plugin . 'Setting';

		// コンポーネントの動的ロード
		$this->$pluginComponent = $this->Components->load($pluginComponent);
		// @see https://book.cakephp.org/2.0/ja/controllers/components.html#id4
		// > コンポーネントを動的にロードした場合、初期化メソッドが実行されないことを覚えておいて下さい。 このメソッドで読込んだ場合、ロード後に手動で実行する必要があります。
		$this->$pluginComponent->initialize($this);

		// $this->AuthXXXXSetting->edit()
		$this->$pluginComponent->edit();
	}

}
