<?php
/**
 * SystemManager Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * システム管理ヘルパー
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SystemManager\View\Helper
 */
class SystemManagerHelper extends AppHelper {

/**
 * 使用するヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'SiteManager.SiteManager',
		'NetCommons.NetCommonsForm',
		'NetCommons.NetCommonsHtml',
	);

/**
 * タブ
 *
 * @var array
 */
	protected $_tabs = array(
		'system_manager' => array(
			'controller' => 'system_manager',
			'action' => 'edit',
		),
		'auth_settings' => array(
			'controller' => 'auth_settings',
			'action' => 'edit',
		),
		'web_server' => array(
			'controller' => 'web_server',
			'action' => 'edit',
		),
		'mail_server' => array(
			'controller' => 'mail_server',
			'action' => 'edit',
		),
		'developer' => array(
			'controller' => 'developer',
			'action' => 'edit',
		),
	);

/**
 * SiteManagerHelperラップ用マジックメソッド。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return mixed
 */
	public function __call($method, $params) {
		return call_user_func_array(array($this->SiteManager, $method), $params);
	}

/**
 * Before render callback. beforeRender is called before the view file is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The view file that is going to be rendered
 * @return void
 */
	public function beforeRender($viewFile) {
		$this->NetCommonsHtml->css(array(
			'/site_manager/css/style.css', '/data_types/css/style.css'
		));
		$this->NetCommonsHtml->script(array(
			'/system_manager/js/system_manager.js'
		));
		parent::beforeRender($viewFile);
	}

/**
 * タブの出力
 *
 * @param string|null $active アクティブタブ
 * @return string HTML
 */
	public function tabs($active = null) {
		if (! isset($active)) {
			$active = $this->_View->request->params['controller'];
		}

		$output = '';
		$output .= '<ul class="nav nav-tabs" role="tablist">';
		foreach ($this->_tabs as $key => $tab) {
			$output .= '<li class="' . ($key === $active ? 'active' : '') . '">';
			$output .= $this->NetCommonsHtml->link(__d('system_manager', 'Tab.' . $key), $tab);
			$output .= '</li>';
		}
		$output .= '</ul>';
		$output .= '<br>';

		return $output;
	}

/**
 * inputタグ
 *
 * @param string $model モデル名
 * @param string $key キー
 * @param array $options オプション
 * @param string $labelPlugin __dのプラグイン名
 * @return string HTML
 */
	public function inputCommon($model, $key, $options = array(), $labelPlugin = 'system_manager') {
		return $this->SiteManager->inputCommon($model, $key, $options, $labelPlugin);
	}

/**
 * inputタグ(言語)
 *
 * @param string $model モデル名
 * @param string $key キー
 * @param array $options オプション
 * @param string $labelPlugin __dのプラグイン名
 * @return string HTML
 */
	public function inputLanguage($model, $key, $options = array(), $labelPlugin = 'system_manager') {
		return $this->SiteManager->inputLanguage($model, $key, $options, $labelPlugin);
	}

}