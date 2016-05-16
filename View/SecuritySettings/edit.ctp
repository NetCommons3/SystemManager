<?php
/**
 * システム管理【セキュリティ設定】テンプレート
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->SystemManager->tabs(); ?>

<?php echo $this->NetCommonsForm->create('SiteSetting', array(
		'ng-controller' => 'SystemManager',
	)); ?>

	<div class="panel panel-default">
		<div class="panel-body">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php echo $this->element('SecuritySettings/upload_allow_extension_form'); ?>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-body">
					<?php echo $this->element('SecuritySettings/deny_ip_move_form'); ?>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-body">
					<?php echo $this->element('SecuritySettings/bad_ips_form'); ?>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-body">
					<?php echo $this->element('SecuritySettings/allow_system_plugin_ips_form'); ?>
				</div>
			</div>
		</div>

		<div class="panel-footer text-center">
			<?php echo $this->Button->cancelAndSave(
					__d('net_commons', 'Cancel'),
					__d('net_commons', 'OK'),
					'#', array('ng-click' => 'cancel()')
				); ?>
		</div>
	</div>


<?php echo $this->NetCommonsForm->end();
