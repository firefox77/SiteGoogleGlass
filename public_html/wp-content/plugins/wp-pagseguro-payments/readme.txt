=== WP PagSeguro Payments ===
Contributors: giovanebribeiro, evertonh
Tags: pagseguro, payment, button
Requires at least: 3.0.1
Tested up to: 3.9.1
Stable tag: 1.0.0
License: Apache License v2.0
License URI: http://www.apache.org/licenses/LICENSE-2.0.html

Adiciona um botão para pagamentos via pagseguro em sua página/post no WP.

== Description ==

ONLY AVAILABLE FOR 'BRL' CURRENCY

SOMENTE DISPONÍVEL PARA TRANSAÇÕES EM MOEDA BRASILEIRA (BRL).

Adiciona um botão para que você possa realizar suas vendas em wordpress de uma forma mais simples, utilizando a API do PagSeguro.

= Recursos =

*	Possibilidade de realizar transações de teste (sandbox)
*	Atalhos fáceis de usar em qualquer página/post dentro do WP
*	Fácil de configurar (Apenas três campos a serem configurados: E-mail, token e URL de retorno)
*	Possibilidade de redirect para mesma página ou outra janela/aba.
*	Menu próprio (dentro das configurações do WP) para edição fácil e prática das configurações citadas acima

= Página no github =

[WP PagSeguro Payments](https://github.com/giovanebribeiro/wp-pagseguro-payment).


== Installation ==

1. Acessar o WP como administrador
2. Clicar em Plugins > Adicionar novo
3. Procurar pelo Plugin 'WP PagSeguro Payments'
4. Seguir as instruções da tela
4.1. Alternativamente, você pode baixar o zip, presente na nossa página no github (seção releases), e carregá-lo no link 'Enviar', na página de plugins.
5. Ativar o plugin
6. Acessar o Menu Configurações > Pagamentos via PagSeguro, e informar seu e-mail e token do PagSeguro, bem como a URL de retorno. A opção sandbox é apenas para testes.
7. Adicione o atalho `[pagseguro_button]` no conteúdo de seu post/página.
8. Para mais opções de uso, ver a página de configurações do plugin

== Frequently Asked Questions ==

= Como adicionar um botão na minha página/post? =

Basta adicionar seguinte código: `[pagseguro_button]`

= Como adicionar um botão no código do meu template? =

Basta adicionar o seguinte código no seu template: `<?php echo do_shortcode("[pagseguro_button]");?>`

= É possível adicionar opções no carregamento do botão? (Ex: adicionar o preço ou a descrição do item) =

Na página de configurações do plugin, existe um pequeno tutorial explicando como adicionar o botão com parâmetros específicos.

== Screenshots ==

1. Tela de configurações.
2. Uso do atalho em uma página de edição de post.

== Upgrade Notice ==

Não é necessária nenhuma configuração adicional, por enquanto.

== Changelog ==

= 1.0 =
*	Possibilidade de realizar transações de teste (sandbox)
*	Atalhos fáceis de usar em qualquer página/post dentro do WP
*	Fácil de configurar (Apenas três campos a serem configurados: E-mail, token e URL de retorno)
*	Menu próprio (dentro das configurações do WP) para edição fácil e prática das configurações citadas acima
*	Possibilidade de redirect para mesma página ou outra janela/aba.
