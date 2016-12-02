<?php
/**
 * ウェブサーバ設定 Element
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
	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Php.memory_limit', array(
		'type' => 'select',
		'options' => $SiteSetting->memoryLimit,
		'label' => __d('system_manager', 'Php.memory_limit'),
	)); ?>

	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Session.cookie', array(
		'label' => __d('system_manager', 'Session.cookie'),
	)); ?>

	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Session.ini.[session.cookie_lifetime]', array(
		'options' => $SiteSetting->sessionTimeout,
		'label' => __d('system_manager', 'Session.ini.[session.cookie_lifetime]'),
		'help' => __d('system_manager', 'Session.ini.[session.cookie_lifetime] help'),
	)); ?>

	<?php echo $this->SystemManager->inputHidden('SiteSetting', 'Session.ini.[session.gc_maxlifetime]', '0'); ?>
</article>
