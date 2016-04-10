<?php
/**
 * 開発者向け Element
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
	<?php echo $this->NetCommonsForm->radio('SiteSetting.only_session',
			array(
				'1' => __d('system_manager', 'Only for this session'),
				'0' => __d('system_manager', 'Save the setting in the DB')
			),
			array(
				'div' => array('class' => 'form-group form-inline'),
				'separator' => '<span class="radio-separator"></span>',
			)
		); ?>

	<hr>

	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'debug', array(
		'type' => 'select',
		'options' => $SiteSetting->debugOptions,
		'help' => true,
	)); ?>
</article>
