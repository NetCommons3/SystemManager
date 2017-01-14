<?php
/**
 * システム管理【メール設定】テンプレート
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php
echo $this->NetCommonsHtml->css('/system_manager/css/style.css');
echo $this->SystemManager->tabs();
?>

<?php echo $this->NetCommonsForm->create('SiteSetting', array(
		'ng-controller' => 'SystemManager',
	)); ?>

	<div class="panel panel-default">
		<div class="panel-body">
			<?php echo $this->SwitchLanguage->tablist('system-settings-'); ?>

			<?php echo $this->element('MailServer/mail_server_form'); ?>
		</div>

		<div class="panel-footer text-center">
			<?php echo $this->Button->cancelAndSave(
					__d('net_commons', 'Cancel'),
					__d('net_commons', 'OK'),
					'#', array('ng-click' => 'cancel()')
				); ?>

			<span class="well well-sm btn-workflow system-manager-check-trial">
				<?php echo $this->NetCommonsForm->checkbox('_SystemManager.trial', array(
					'label' => __d('system_manager', 'Can send mail or test send'),
					'checked' => false,
					'inline' => true,
				)); ?>
			</span>
		</div>
	</div>


<?php echo $this->NetCommonsForm->end();
