<?php
/**
 * DeveloperSettings Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SystemManagerAppController', 'SystemManager.Controller');

/**
 * システム管理【開発者向け】
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SystemManager\Controller
 */
class DeveloperController extends SystemManagerAppController {

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
			$settings = $this->SiteSetting->find('all', array(
				'recursive' => -1,
				'conditions' => array('SiteSetting.key' => array(
					// * デバッグ出力
					'debug',
				))
			));
			$this->request->data['SiteSetting'] = Hash::combine($settings,
				'{n}.SiteSetting.language_id',
				'{n}.SiteSetting',
				'{n}.SiteSetting.key'
			);
		}
	}
}
