<?php
/**
 * SystemManagerApp Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * SystemManagerApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SystemManager\Controller
 */
class SystemManagerAppController extends AppController {

/**
 * 使用コンポーネント
 *
 * @var array
 */
	public $components = array(
		'Auth.AuthPlugin',
		'ControlPanel.ControlPanelLayout',
		'M17n.SwitchLanguage',
		'NetCommons.Permission' => array(
			'type' => PermissionComponent::CHECK_TYPE_SYSTEM_PLUGIN,
			'allow' => array()
		),
		'Security',
		'SiteManager.SiteManager',
	);

/**
 * 使用ヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'SystemManager.SystemManager',
	);

/**
 * beforeFilter
 *
 * @return void
 * @see SystemManagerHelper::tabs()
 **/
	public function beforeFilter() {
		// 外部認証プラグイン(AuthXXX)があれば、ログイン設定タブを表示
		if ($this->AuthPlugin->getExternals()) {
			$this->set('useAuthSettingTab', true);
		} else {
			$this->set('useAuthSettingTab', false);
		}

		parent::beforeFilter();
	}
}
