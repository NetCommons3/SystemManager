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
	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'Security.deny_ip_move', array(
		'type' => 'select',
		'childDiv' => array('class' => 'form-inline'),
		'multiple' => 'checkbox',
		'options' => $userRoles,
		'value' => explode('|', $this->SystemManager->getValue('SiteSetting', 'Security.deny_ip_move')),
		'help' => true,
	)); ?>
</article>
