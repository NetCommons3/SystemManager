<?php
/**
 * セキュリティ設定 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article>
	<?php $domId = $this->SystemManager->domId('SiteSetting.Security.enable_allow_system_plugin_ips'); ?>
	<div ng-init="<?php echo $domId . ' = ' . (int)$this->SystemManager->getValue('SiteSetting', 'Security.enable_allow_system_plugin_ips'); ?>">
		<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Security.enable_allow_system_plugin_ips', array(
				'type' => 'radio',
				'ng-click' => $domId . ' = click($event)',
				'options' => array(
					'1' => __d('net_commons', 'Yes'),
					'0' => __d('net_commons', 'No'),
				),
			)); ?>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Security.allow_system_plugin_ips', array(
				'required' => true,
				'help' => true,
			)); ?>
		</div>
	</div>
</article>
