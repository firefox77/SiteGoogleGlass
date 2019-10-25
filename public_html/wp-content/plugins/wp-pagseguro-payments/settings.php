<?php
/*
 * settings.php - Página de configurações do plugin
 * @author Giovane Boaviagem Ribeiro
 */
?>

<div class="wrap">
	<h1>Configurações para acesso ao PagSeguro</h1>
	<div>
		<h3>Utilização básica</h3>
		<p>Para Adicionar um botão do pagseguro na sua página (ou nos seus posts), você deve utilizar o seguinte comando: <code>[pagseguro_button]</code></p>
		<p>Para Adicionar um botão do pagseguro diretamente no seu template, use o seguinte código: <code>&lt;?php do_shortcode("[pagseguro_button]"); ?&gt;</code></p>
		<p>Os seguintes atributos são permitidos:
			<table class="form-table">
				<tr valign="top">
					<th scope="row">item_id</th>
					<td>Representa um identificador do produto a ser vendido. Valor padrão: '1'</td>
				</tr>
				<tr valign="top">
					<th scope="row">item_descricao</th>
					<td>Representa a descrição do Item a ser vendido. Valor padrão: 'Descrição de item'</td>
				</tr>
				<tr valign="top">
					<th scope="row">item_qtd</th>
					<td>Representa a quantidade de itens a serem vendidos. Valor padrão: '1'</td>
				</tr>
				<tr valign="top">
					<th scope="row">item_valor</th>
					<td>Representa o valor total da compra. Como separador decimal, podem ser usados tanto vírgulas quanto pontos. Valor padrão: '0,01'
				</tr>
			</table>
		</p>
		<p>Assim, para adicionar um botão de uma compra que vale R$ 100,00, o seguinte comando pode ser usado: <code>[pagseguro_button item_valor="100,00"]</code> (Os demais atributos são os valores padrão)</p>
	</div>
	<div>
		<h3>Configurações</h3>
		<form method="post" action="options.php">
			<?php settings_fields('ps_settings_group');?>
			<?php do_settings_sections('ps_settings_group');?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">E-mail para acesso ao PagSeguro</th>
			 		<td><input type="text" name="ps_config_auth_email" value="<?php echo get_option('ps_config_auth_email'); ?>"/></td>
				</tr>
				<tr valign="top">
					<th scope="row">Token para acesso ao PagSeguro</th>
			 		<td><input type="text" name="ps_config_auth_token" value="<?php echo get_option('ps_config_auth_token'); ?>"/></td>
				</tr>
				<tr valign="top">
					<th scope="row">URL de retorno (URLs que possuam 'localhost' não vão funcionar)</th>
			 		<td><input type="text" name="ps_config_return_url" value="<?php echo get_option('ps_config_return_url'); ?>"/></td>
				</tr>
			</table>
			<?php
			$tag="<input type='checkbox' name='ps_config_newpage' value='yes' ";
			$newpage=get_option('ps_config_newpage');
			if(strlen($newpage)>0){
				$tag.="checked";
			}
			$tag.="> <b>O redirecionamento para o site do PagSeguro deve ser feito em outra página?</b>";
			echo($tag);

			echo ("<br>");
			echo ("<br>");

			$tag="<input type='checkbox' name='ps_config_enable_sandbox' value='yes' ";
			$sandbox=get_option('ps_config_enable_sandbox');
			if(strlen($sandbox)>0){
				$tag.="checked";
			}
			$tag.="> <b>Sandbox (somente para desenvolvedores)</b>";
			echo($tag);
			echo("");
			
			?>
			<?php submit_button(); ?>
		</form>
	</div>
</div>

