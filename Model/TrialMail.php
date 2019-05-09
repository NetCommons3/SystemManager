<?php
/**
 * メールテスト送信用Model
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SystemManagerAppModel.php', 'SystemManager.Model');

/**
 * メールテスト送信用Model
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\SystemManager\Controller
 */
class TrialMail extends SystemManagerAppModel {

/**
 * テーブル名
 *
 * @var mixed
 */
	public $useTable = false;

/**
 * 使用ビヘイビア
 *
 * @var array
 */
	public $actsAs = array(
		'Mails.MailQueue' => array(
			'embedTags' => array(
				'X-SUBJECT' => 'UserMail.title',
				'X-BODY' => 'UserMail.body',
			),
		),
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = ValidateMerge::merge($this->validate, array(
			'to_address' => array(
				'email' => array(
					'rule' => array('email'),
					'message' => sprintf(
						__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'),
						__d('system_manager', 'To mail address'),
						__d('net_commons', 'Email')
					),
					'required' => true,
				),
			),
			//			'reply_to' => array(
			//				'email' => array(
			//					'rule' => array('email'),
			//					'message' => sprintf(
			//						__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'),
			//						__d('system_manager', 'Reply to mail address'),
			//						__d('net_commons', 'Email')
			//					),
			//					'required' => false,
			//					'allowEmpty' => true
			//				),
			//			),
			'title' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(
						__d('net_commons', 'Please input %s.'), __d('user_manager', 'Mail title')
					),
					'required' => true
				),
			),
			'body' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('user_manager', 'Mail body')),
					'required' => true
				),
			),
		));

		return parent::beforeValidate($options);
	}
}
