<?php
/**
 * SystemManager Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SystemManagerAppController', 'SystemManager.Controller');

/**
 * システム管理【一般設定】
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\SystemManager\Controller
 */
class SystemManagerController extends SystemManagerAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'SiteManager.SiteSetting',
		'Rooms.Space',
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
					// * サイトタイムゾーン
					'App.default_timezone',
				)
			));

			$spaces = $this->Space->find('all', array(
				'recursive' => -1,
				'conditions' => array('id' => [Space::PRIVATE_SPACE_ID, Space::ROOM_SPACE_ID]),
			));
			// * グループルームの容量
			$this->request->data['SiteSetting']['App.disk_for_group_room']['0'] = $this->SiteSetting->create(
				array(
					'key' => 'App.disk_for_group_room',
					'language_id' => '0',
					'value' => Hash::extract($spaces, '{n}.Space[type=' . Space::ROOM_SPACE_ID . '].room_disk_size')[0]
				)
			)['SiteSetting'];

			// * プライベートルームの容量
			$this->request->data['SiteSetting']['App.disk_for_private_room']['0'] = $this->SiteSetting->create(
				array(
					'key' => 'App.disk_for_private_room',
					'language_id' => '0',
					'value' => Hash::extract($spaces, '{n}.Space[type=' . Space::PRIVATE_SPACE_ID . '].room_disk_size')[0]
				)
			)['SiteSetting'];
		}
	}
}
