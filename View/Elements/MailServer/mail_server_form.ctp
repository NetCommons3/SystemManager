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
		'label' => __d('system_manager', 'Mail.from'),
	)); ?>

	<?php echo $this->SystemManager->inputLanguage('SiteSetting', 'Mail.from_name', array(
		'label' => __d('system_manager', 'Mail.from_name'),
		'help' => __d('system_manager', 'Mail.from_name help'),
	)); ?>

	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.messageType', array(
			'type' => 'radio',
			'options' => $SiteSetting->mailMessageType,
			'label' => __d('system_manager', 'Mail.messageType'),
		)); ?>

	<?php $transportDomId = $this->SystemManager->domId('SiteSetting.Mail.transport'); ?>
	<div ng-init="<?php echo $transportDomId . ' = \'' . h($this->SystemManager->getValue('SiteSetting', 'Mail.transport') . '\''); ?>">
		<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.transport', array(
			'type' => 'select',
			'options' => $SiteSetting->mailTransport,
			'ng-model' => $transportDomId,
			'label' => __d('system_manager', 'Mail.transport'),
			'help' => __d('system_manager', 'Mail.transport help'),
		)); ?>

		<div class="row" ng-show="<?php echo $transportDomId . ' === \'' . SiteSetting::MAIL_TRANSPORT_SMTP . '\''; ?>">
			<div class="col-xs-offset-1 col-xs-11">
				<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.host', array(
						'required' => true,
						'label' => __d('system_manager', 'Mail.smtp.host'),
						'help' => __d('system_manager', 'Mail.smtp.host help'),
					)); ?>

				<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.port', array(
						'required' => true,
						'label' => __d('system_manager', 'Mail.smtp.port'),
						'help' => __d('system_manager', 'Mail.smtp.port help'),
					)); ?>

				<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.user', array(
						'label' => __d('system_manager', 'Mail.smtp.user'),
						'help' => __d('system_manager', 'Mail.smtp.user help'),
					)); ?>

				<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.pass', array(
						'type' => 'password',
						'label' => __d('system_manager', 'Mail.smtp.pass'),
						'help' => __d('system_manager', 'Mail.smtp.pass help'),
					)); ?>

				<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Mail.smtp.tls', array(
						'type' => 'radio',
						'options' => array(
							'1' => __d('net_commons', 'Yes'),
							'0' => __d('net_commons', 'No'),
						),
						'label' => __d('system_manager', 'Mail.smtp.tls'),
						'help' => __d('system_manager', 'Mail.smtp.tls help'),
					)); ?>
			</div>
		</div>
	</div>
</article>
