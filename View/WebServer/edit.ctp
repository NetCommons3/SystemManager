<?php
/**
 * システム管理【サーバ設定】テンプレート
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
			<?php echo $this->element('WebServer/web_server_form'); ?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo __d('system_manager', 'Proxy server'); ?>
				</div>

				<div class="panel-body">
					<?php echo $this->element('WebServer/proxy_form'); ?>
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
