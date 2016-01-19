<?php
/**
 * メールサーバ Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article>
	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.from', array(
		'required' => true,
	)); ?>

	<?php echo $this->SystemManager->inputLanguage('SiteSetting', 'Mail.from_name', array(
		'description' => true
	)); ?>

	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.messageType', array(
			'type' => 'radio',
			'options' => array(
				'html' => __d('system_manager', 'HTML'),
				'text' => __d('system_manager', 'Plan text'),
			),
		)); ?>

	<?php $transportDomId = $this->SystemManager->domId('SiteSetting.Mail.transport'); ?>
	<div ng-init="<?php echo $transportDomId . ' = \'' . h($this->SystemManager->getValue('SiteSetting', 'Mail.transport') . '\''); ?>">
		<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.transport', array(
			'type' => 'select',
			'options' => array(
				'phpmail' => __d('system_manager', 'PHP mail()'),
				'sendmail' => __d('system_manager', 'sendmail'),
				'smtp' => __d('system_manager', 'SMTP'),
			),
			'ng-model' => $transportDomId,
			//'ng-change' => 'select(\'' . $transportDomId . '\', $event)',
			'description' => true,
		)); ?>

		<div ng-show="<?php echo $transportDomId; ?> === 'sendmail'">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.sendmail', array(
					'required' => true,
					'description' => true,
				)); ?>
		</div>

		<div ng-show="<?php echo $transportDomId; ?> === 'smtp'">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.host', array(
					'required' => true,
					'description' => true,
				)); ?>
		</div>

		<div ng-show="<?php echo $transportDomId; ?> === 'smtp'">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.port', array(
					'description' => true,
				)); ?>
		</div>

		<div ng-show="<?php echo $transportDomId; ?> === 'smtp'">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.user', array(
				)); ?>
		</div>

		<div ng-show="<?php echo $transportDomId; ?> === 'smtp'">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.pass', array(
					'type' => 'password'
				)); ?>
		</div>
	</div>
</article>
