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

App::uses('SiteSetting', 'SiteManager.Model');
$SiteSetting = new SiteSetting();
$SiteSetting->prepare();
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
			'options' => $SiteSetting->mailMessageType,
		)); ?>

	<?php $transportDomId = $this->SystemManager->domId('SiteSetting.Mail.transport'); ?>
	<div ng-init="<?php echo $transportDomId . ' = \'' . h($this->SystemManager->getValue('SiteSetting', 'Mail.transport') . '\''); ?>">
		<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.transport', array(
			'type' => 'select',
			'options' => $SiteSetting->mailTransport,
			'ng-model' => $transportDomId,
			'description' => true,
		)); ?>

		<div ng-show="<?php echo $transportDomId . ' === \'' . SiteSetting::MAIL_TRANSPORT_SMTP . '\''; ?>">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.host', array(
					'required' => true,
					'description' => true,
				)); ?>
		</div>

		<div ng-show="<?php echo $transportDomId . ' === \'' . SiteSetting::MAIL_TRANSPORT_SMTP . '\''; ?>">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.port', array(
					'required' => true,
					'description' => true,
				)); ?>
		</div>

		<div ng-show="<?php echo $transportDomId . ' === \'' . SiteSetting::MAIL_TRANSPORT_SMTP . '\''; ?>">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.user', array(
				)); ?>
		</div>

		<div ng-show="<?php echo $transportDomId . ' === \'' . SiteSetting::MAIL_TRANSPORT_SMTP . '\''; ?>">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.pass', array(
					'type' => 'password'
				)); ?>
		</div>
	</div>
</article>
