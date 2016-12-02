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
	<?php $domId = $this->SystemManager->domId('SiteSetting.Security.enable_bad_ips'); ?>
	<div ng-init="<?php echo $domId . ' = ' . (int)$this->SystemManager->getValue('SiteSetting', 'Security.enable_bad_ips'); ?>">
		<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Security.enable_bad_ips', array(
				'type' => 'radio',
				'ng-click' => $domId . ' = click($event)',
				'options' => array(
					'1' => __d('net_commons', 'Yes'),
					'0' => __d('net_commons', 'No'),
				),
				'label' => __d('system_manager', 'Security.enable_bad_ips'),
			)); ?>

		<div class="row" ng-show="<?php echo $domId; ?>" ng-cloak>
			<div class="col-xs-offset-1 col-xs-11">
				<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Security.bad_ips', array(
					'required' => true,
					'label' => __d('system_manager', 'Security.bad_ips'),
					'help' => '<div class="help-block">' . __d('system_manager', 'Security.bad_ips help') . '</div>' .
							'<div class="alert alert-warning">' .
								__d('system_manager', 'If you enter the wrong IP address, You will not be able to access the web site. ' .
											'Please enter did on each confirmed well.') .
							'</div>',
					'helpOptions' => array('escape' => false)
				)); ?>
			</div>
		</div>
	</div>
</article>
