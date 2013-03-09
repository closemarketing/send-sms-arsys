<?php
function sms_options_page() {
$sms_api_user = get_option( "sms_user" );
$sms_api_pass = get_option( "sms_password" );
$sms_from = get_option( "sms_from" );
$sms_metavar = get_option( "sms_metavar" );
$sms_codecountry = get_option( "sms_codecountry" );
?>
	<div class="wrap">
		<h2><?php _e('Opciones', 'sendsms'); ?></h2>
		<p>Rellena los datos necesarios para el env&iacute;o de SMS. Recuerda que este Plugin utiliza la plataforma Arsys para los SMS.</p>

		<br/>
		<form name='sms_update_options' id='sms_update_options' method='POST' action='<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ?>'>
			<table>
				<tr>
					<td><?php _e('Usuario API', 'sendsms'); ?></td>
					<td><input type="text" name="sms_api_user" value="<?php echo $sms_api_user;?>"/></td>
				</tr>
				<tr>
					<td><?php _e('Contrase&ntilde;a API', 'sendsms'); ?></td>
					<td><input type="text" name="sms_api_pass" value="<?php echo $sms_api_pass;?>"/></td>
				</tr>
				<tr>
					<td><?php _e('Remite SMS', 'sendsms'); ?></td>
					<td><input type="text" name="sms_from" value="<?php echo $sms_from;?>"/></td>

				<tr>
					<td><?php _e('Variable Usuario WP', 'sendsms'); ?></td>
					<td><input type="text" name="sms_metavar" value="<?php echo $sms_metavar;?>"/></td>
				</tr>
				<tr>
					<td><?php _e('C&oacute;digo Pa&iacute;s', 'sendsms'); ?></td>
					<td><input type="text" name="sms_codecountry" value="<?php echo $sms_codecountry;?>"/></td>
				</tr>
			</table><br/>
			<span class="submit"><input type="submit" value="Update" name="sms_options"/></span>
		</form>
	</div>
	<br/>
	<div>
	</div>
<?php
}

function sms_meta_box_send(){
	global $smssuccfail;
	$sms_maxlen = "160";
?>
	<div style="padding: 10px;">
		<form name='send_sms_form' id='send_sms_form' method='POST'>
			<table>
				<tr>
					<td><?php _e('Texto Mensaje:', 'sendsms'); ?></td>
				</tr>
				<tr>
					<td>
						<textarea maxlength="<?php echo $sms_maxlen; ?>" name="sms_message" id="sms_message" style="width: 591px; height: 50px;"></textarea>
					</td>
				</tr>
				<tr>
					<td><input size=5 value="<?php echo $sms_maxlen; ?>" name="sms_left" id="sms_left" readonly="true"> <?php _e('Car&aacute;cteres', 'sendsms'); ?></td>
				</tr>
				<tr>
					<td>

					<?php
					$result = count_users();
					echo '<p><b>Total Usuarios Registrados: ', $result['total_users'], ' </b></p>'; ?>
					<b><?php _e('Enviar al Grupo de Usuarios:', 'sendsms'); ?></b>
					<?php
					  //Selección Permisos
			          $roles_list = get_editable_roles();

			          echo '<select name="actrol" style="width:97%;" value="">';
			          echo '<option value=""></option>';
			          foreach ($roles_list as $role => $details) {
			              $roles_ID = esc_attr($role);
			              $roles_name = translate_user_role($details['name'] );



			              foreach($result['avail_roles'] as $role => $count) {
							if ($roles_ID == $role) {
							echo '<option value="'.$roles_ID.'">'.$roles_name;
						    echo ' -> '.$count.' usuario';
						    if ($count>1) { echo 's'; }
						    echo '</option>';
						    } //if roles_ID
						  }


			          }
			          echo '</select>';

			          ?>



					</td>
				</tr>
			</table>
			<span class="submit"><input type="submit" value="<?php _e('Enviar Mensajes', 'sendsms'); ?>" /></span>
		</form>
<?php
		echo $smssuccfail;
		$smssuccfail = '';?>
	</div>
<?php
}

function sms_main_page() {
	global $smssuccfail;
?>
	<div class="wrap">
		<h2><?php _e('Panel Env&iacute;o SMS v&iacute;a Arsys','sendsms'); ?></h2>
	</div>
<?php
	add_meta_box("sms_send", "Env&iacute;o Mensajes SMS a un Grupo de Usuarios", "sms_meta_box_send", "sms");
?>
	<div id="dashboard-widgets-wrap">
		<div class="metabox-holder">
			<div style="float:left; width:50%;" class="inner-sidebar1">
<?php
	do_meta_boxes('sms','advanced','');
?>
			</div>
			<div style="float:right; width:50%;" class="inner-sidebar2">
<?php
	do_meta_boxes('smsstats','advanced','');
?>
			</div>
		</div>
	</div>
<?php
}

?>