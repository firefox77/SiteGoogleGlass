<?php
/**
 * Plugin Name: WP Pagseguro Payment
 * Plugin URI: 
 * Description: Implement a PagSeguro button to make payments easily
 * Version: 1.0
 * Author: giovanebribeiro
 * Author URI: 
 */

function app_output_buffer(){
	ob_start();
}
add_action('init','app_output_buffer');

/*
 * Aqui são carregados todos os scripts do plugin (Javascript, css)
 */
function ps_load_scripts(){
	/*
	 * carrega o arquivo CSS
	 */
	wp_register_style('ps_style',plugins_url('styles.css',__FILE__));
	wp_enqueue_style('ps_style');
}
add_action('wp_enqueue_scripts','ps_load_scripts');


/**
 * Monta a pagina de configuracoes do nosso plugin
 */
function ps_settings_page(){
	include("settings.php");
}
/**
 * Registra as configuracoes do plugin
 */
function ps_register_settings(){
	register_setting('ps_settings_group','ps_config_auth_email');
	register_setting('ps_settings_group','ps_config_auth_token');
	register_setting('ps_settings_group','ps_config_return_url');
	register_setting('ps_settings_group','ps_config_enable_sandbox');
	register_setting('ps_settings_group','ps_config_newpage');
}
/**
 * Adiciona mais um menu no wp-admin, para controlar o nosso plugin
 */
function ps_settings_page_init(){	
	/*
	 * Argumentos:
	 * - Titulo da pagina
	 * - Titulo do menu
	 * - habilidade do menu a ser exibido
	 * - Identificador do menu
	 * - Nome da funcao a ser executada (callback)
	 */
	add_options_page('Pagamentos via PagSeguro', 'Pagamentos via PagSeguro', 'manage_options', __FILE__, 'ps_settings_page');

	/*
	 * Adiciona a action para adicionar as configuracoes do plugin
	 */
	add_action('admin_init','ps_register_settings');

}
add_action('admin_menu', 'ps_settings_page_init'); //registra a action correspondente

/**
 * Adiciona o atalho a ser colocado nas páginas e posts.
 * Atributos a serem considerados.
 */
function ps_start($args){
	/*
	 * Carrega os atributos do atalho. Caso o atalho não possua algum dos parametros abaixo, este parametro será substituído pelo parametro default abaixo.
	 */
	$a=shortcode_atts(array(
		'item_id' => '1',
		'item_descricao' => 'Descrição de item',
		'item_qtd' => '1',
		'item_valor' => '0,01'),$args);

	if(isset($_POST['submit'])){
		process_form();
	}

	/*
	 * Carrega o form de submissao para o botao do pagseguro
	 */
	$newpage=get_option("ps_config_newpage");
	$headerForm="<form method='post' action='' ";
	if(strlen($newpage)>0){
		$headerForm.=" target='_blank'";
	}

	$headerForm.=">";
	echo($headerForm);
	?>
		<input name="item_id" type="hidden" value="<?php echo $a['item_id']?>">
		<input name="item_descricao" type="hidden" value="<?php echo $a['item_descricao']?>">
		<input name="item_qtd" type="hidden" value="<?php echo $a['item_qtd']?>">
		<input name="item_valor" type="hidden" value="<?php echo $a['item_valor']?>">
		<input name="submit" type="submit" value="Pagar com PagSeguro" class="pagseguro">
	</form>
	<?php
	
}
add_shortcode('pagseguro_button','ps_start'); //registra o atalho

/**
 * Processa o formulário, 
 */
function process_form(){
	// var_dump($_POST);
	// die();

	require_once("PagSeguroLibrary/PagSeguroLibrary.php");

	$id=$_POST['item_id'];
	$descricao=$_POST['item_descricao'];
	$qtd=$_POST['item_qtd'];
	$valor=$_POST['item_valor'];

	$valor=str_replace(",",".",$valor);

	//Instancia uma requisicao de pagamento
	$paymentRequest=new PagSeguroPaymentRequest();

	//Seta a moeda
	$paymentRequest->setCurrency("BRL");

	//Adiciona os itens para gerar a url
	$paymentRequest->addItem($id,$descricao,$qtd,$valor);

	//Seta o ambiente de producao, se é Sandbox, ou production
	$is_sandbox=get_option('ps_config_enable_sandbox');
	if(strlen($is_sandbox)>0){
		PagSeguroConfig::setEnvironment('sandbox');
	}else{
		PagSeguroConfig::setEnvironment('production');
	}
	
	/* Infos seguintes apenas para referencia*/
	// Add another item for this payment request
	//$paymentRequest->addItem('0002', 'Notebook rosa', 2, 1.00);

	// Sets a reference code for this payment request, it is useful to identify this payment in future notifications.
	//$paymentRequest->setReference($dadosComprador["codReference"]);

	// Sets shipping information for this payment request
	// 		$CODIGO_SEDEX = PagSeguroShippingType::getCodeByType('SEDEX');
	// 		$paymentRequest->setShippingType($CODIGO_SEDEX);
	// 		$paymentRequest->setShippingAddress($dadosComprador["cep"], $dadosComprador["logradouro"], $dadosComprador["numero"], $dadosComprador["complemento"], $dadosComprador["bairro"], $dadosComprador["cidade"], $dadosComprador["estado"], 'BRA');

	// Sets your customer information.
	//$paymentRequest->setSender($dadosComprador["nome"] . ' ' . $dadosComprador["sobrenome"], $dadosComprador["email"]);

	//Seta a URL de retorno
	$paymentRequest->setRedirectUrl(get_option('ps_config_return_url'));

	try{
		//Inicializa as credenciais
		$credentials=new PagSeguroAccountCredentials(get_option('ps_config_auth_email'),get_option('ps_config_auth_token'));
		
		//obtem-se a URL da compra
		$url=$paymentRequest->register($credentials);

		//faz o redirect para a url do pagseguro
		wp_redirect($url);
		exit();
	} catch(PagSeguroServiceException $e){
		die($e->getMessage());
	}
}

?>