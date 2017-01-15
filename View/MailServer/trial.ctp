<?php
/**
 * システム管理【メール設定-テスト送信】テンプレート
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php
echo $this->SystemManager->tabs();
echo $this->MessageFlash->description(__d('system_manager', 'When sending mail or sending test e-mail, please press the [Send] button.'));
?>

<div class="panel panel-default">
	<?php echo $this->NetCommonsForm->create('TrialMail'); ?>

		<div class="panel-body">
			<?php echo $this->NetCommonsForm->input('TrialMail.to_address', array(
					'type' => 'text',
					'label' => __d('system_manager', 'To mail address'),
					'required' => true,
					//'value' => $user['email']
				)); ?>

			<?php /*echo $this->NetCommonsForm->input('TrialMail.reply_to', array(
					'type' => 'text',
					'label' => __d('system_manager', 'Reply to mail address'),
				));*/ ?>

			<?php echo $this->NetCommonsForm->input('TrialMail.title', array(
					'type' => 'text',
					'label' => __d('system_manager', 'Mail title'),
					'required' => true
				)); ?>

			<?php echo $this->NetCommonsForm->input('TrialMail.body', array(
					'type' => 'textarea',
					'label' => __d('system_manager', 'Mail body'),
					'required' => true
				)); ?>
		</div>

		<div class="panel-footer text-center">
			<?php
				echo $this->Button->cancel(
					__d('net_commons', 'Close'),
					array('controller' => 'mail_server', 'action' => 'edit')
				);

				echo $this->NetCommonsForm->button(
					'<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> ' . __d('system_manager', 'Send'),
					array(
						'class' => 'btn btn-primary btn-workflow',
						'name' => 'send',
						'ng-disabled' => 'sending'
					)
				);
			?>
		</div>
	<?php echo $this->NetCommonsForm->end(); ?>
</div>
