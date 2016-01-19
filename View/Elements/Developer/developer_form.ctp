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
?>

<article>
	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'debug', array(
		'type' => 'select',
		'options' => array(
			'0' => __d('system_manager', '0: No error messages, errors, or warnings shown. Flash messages redirect.'),
			'1' => __d('system_manager', '1: Errors and warnings shown, model caches refreshed, flash messages halted.'),
			'2' => __d('system_manager', '2: As in 1, but also with full debug messages and SQL output.'),
		),
		'description' => true,
	)); ?>
</article>
