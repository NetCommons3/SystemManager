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

			$spaces = $this->Space->cacheFindQuery('all', array(
				'recursive' => -1,
				'conditions' => array('id' => [Space::PRIVATE_SPACE_ID, Space::COMMUNITY_SPACE_ID, Space::PUBLIC_SPACE_ID]),
			));

			$setSpaceDisk = array(
				// パブリックルームの容量
				Space::PUBLIC_SPACE_ID => 'App.disk_for_public_room',
				// * グループルームの容量
				Space::COMMUNITY_SPACE_ID => 'App.disk_for_group_room',
				// * プライベートルームの容量
				Space::PRIVATE_SPACE_ID => 'App.disk_for_private_room',
			);
			foreach ($setSpaceDisk as $spaceId => $key) {
				$this->request->data['SiteSetting'][$key]['0'] = $this->SiteSetting->create(
					array(
						'key' => $key,
						'language_id' => '0',
						'value' => Hash::extract($spaces, '{n}.Space[id=' . $spaceId . '].room_disk_size')[0]
					)
				)['SiteSetting'];
			}
		}
	}
}
