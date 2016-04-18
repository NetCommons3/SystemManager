<?php
/**
 * 一般設定 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteSetting', 'SiteManager.Model');
App::uses('CakeNumber', 'Utility');

$SiteSetting = new SiteSetting();
$SiteSetting->prepare();

foreach ($SiteSetting->diskSpace as $size) {
	if ($size < 0) {
		$diskSpace[$size] = __d('system_manager', 'Unlimited');
	} else {
		$diskSpace[$size] = CakeNumber::toReadableSize($size);
	}
}
?>

<article>
	<?php echo $this->SystemManager->inputLanguage('SiteSetting', 'App.default_timezone', array(
		'type' => 'select',
		'options' => $SiteSetting->defaultTimezones
	)); ?>

	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'App.disk_for_group_room', array(
		'type' => 'select',
		'options' => $diskSpace,
		'help' => true
	)); ?>

	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'App.disk_for_private_room', array(
		'type' => 'select',
		'options' => $diskSpace,
		'help' => true
	)); ?>
</article>
