<?php
/**
 * システム管理【ログイン設定】テンプレート
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->SystemManager->tabs(); ?>

<?php echo $this->NetCommonsForm->create('SiteSetting', array(
		'ng-controller' => 'SystemManager',
		'ng-init' => $this->SystemManager->domId('activeAuthTab') . ' = \'' . h($activeAuthTab) . '\''
	)); ?>

	<?php $this->NetCommonsForm->unlockField('activeAuthTab'); ?>
	<?php echo $this->NetCommonsForm->hidden('activeAuthTab', array(
		'ng-value' => $this->SystemManager->domId('activeAuthTab')
	)); ?>

	<div>
	<?php echo $this->SystemManager->authTabs(); ?>

	<div class="panel panel-default">
		<div class="panel-body">
			<div class="tab-content">
				<?php foreach ($authTabs as $key => $tab) : ?>
					<div id="<?php echo $key; ?>"
							class="tab-pane<?php echo ($activeAuthTab === $key ? ' active' : ''); ?>" >

						<?php echo $this->element($tab['element']); ?>
					</div>
				<?php endforeach; ?>
			</div>

		</div>

		<div class="panel-footer text-center">
			<?php echo $this->Button->cancelAndSave(
					__d('net_commons', 'Cancel'),
					__d('net_commons', 'OK'),
					$this->NetCommonsHtml->url(array('action' => 'edit'))
				); ?>
		</div>
	</div>

<?php echo $this->NetCommonsForm->end();
