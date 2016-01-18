<?php
/**
 * 一般設定Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('M17nHelper', 'M17n.View/Helper');
?>

<article>
	<?php echo $this->SystemManager->inputLanguage('SiteSetting', 'App.default_timezone', array(
		'type' => 'select',
		//'options' => array_map('__', array_intersect_key(M17nHelper::$languages, array_flip($languages))),
		//'description' => true
	)); ?>

	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'App.disk_for_group_room', array(
		'type' => 'select',
		//'options' => $rooms,
		'description' => true
	)); ?>

	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'App.disk_for_private_room', array(
		'type' => 'select',
		//'options' => $rooms,
		'description' => true
	)); ?>
</article>
