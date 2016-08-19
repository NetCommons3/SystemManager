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

		<div class="row" ng-show="<?php echo $domId; ?>" ng-cloak>
			<div class="col-xs-offset-1 col-xs-11">
				<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Proxy.host', array(
						'help' => true,
						'required' => true,
					)); ?>

				<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Proxy.port', array(
						'help' => true,
						'required' => true,
					)); ?>

				<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Proxy.user', array(
						'help' => true,
					)); ?>

				<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Proxy.pass', array(
						'type' => 'password',
						'help' => true,
					)); ?>
			</div>
		</div>
	</div>
</article>
