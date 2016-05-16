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

$this->NetCommonsHtml->css(array(
	'/system_manager/css/style.css'
));

App::uses('SiteSetting', 'SiteManager.Model');
$SiteSetting = new SiteSetting();
$SiteSetting->prepare();
?>

<article>
	<div class="form-group">
		<?php echo $this->NetCommonsForm->radio('SiteSetting.only_session',
				array(
					'1' => __d('system_manager', 'Only for this session'),
					'0' => __d('system_manager', 'Save the setting in the DB')
				)
			); ?>
	</div>

	<hr>

	<?php echo $this->SystemManager->inputCommon('SiteSetting', 'debug', array(
		'type' => 'select',
		'options' => $SiteSetting->debugOptions,
		'help' => true,
	)); ?>
</article>
