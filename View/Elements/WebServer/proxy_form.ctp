<?php
/**
 * プロキシサーバ設定 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article>
	<?php $domId = $this->SystemManager->domId('SiteSetting.Proxy.use_proxy'); ?>
	<div ng-init="<?php echo $domId . ' = ' . (int)$this->SystemManager->getValue('SiteSetting', 'Proxy.use_proxy'); ?>">

		<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Proxy.use_proxy', array(
				'type' => 'radio',
				'ng-click' => $domId . ' = click($event)',
				'options' => array(
					'1' => __d('net_commons', 'Yes'),
					'0' => __d('net_commons', 'No'),
				),
			)); ?>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Proxy.host', array(
					'description' => true,
				)); ?>
		</div>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Proxy.port', array(
					'description' => true,
				)); ?>
		</div>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Proxy.user', array(
					'description' => true,
				)); ?>
		</div>

		<div ng-show="<?php echo $domId; ?>">
			<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Proxy.pass', array(
					'type' => 'password',
					'description' => true,
				)); ?>
		</div>

</article>
