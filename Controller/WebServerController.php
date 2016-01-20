<?php
/**
 * SiteManager Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SystemManagerAppController', 'SystemManager.Controller');

/**
 * システム管理【サーバ設定】
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SystemManager\Controller
 */
class WebServerController extends SystemManagerAppController {

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
					// * システムコンフィグ
					// ** PHP最大メモリ数
					'Php.memory_limit',
					// * セッション
					// ** Cookieの名称
					'Session.ini.session.name',

					// * プロキシ
					// ** プロキシサーバを使用する
					'Proxy.use_proxy',
					// ** プロキシホスト
					'Proxy.host',
					// ** プロキシポート番号
					'Proxy.port',
					// ** プロキシユーザ名
					'Proxy.user',
					// ** プロキシパスワード
					'Proxy.pass',
				)
			));
		}
	}
}