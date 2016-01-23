<?php
/**
 * ログイン・ログアウト設定 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteSetting', 'SiteManager.Model');
$SiteSetting = new SiteSetting();
$SiteSettin->prepare();
?>

<article>
	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Session.ini.session.cookie_lifetime', array(
		'options' => $SiteSetting->sessionTimeout,
		'description' => true
	)); ?>

	<?php echo $this->SystemManager->inputHidden('SiteSetting', 'Session.ini.session.gc_maxlifetime', '0'); ?>

	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Auth.use_ssl', array(
		'type' => 'radio',
		'options' => array(
			'1' => __d('net_commons', 'Yes'),
			'0' => __d('net_commons', 'No'),
		),
		'description' => true
	)); ?>

</article>
