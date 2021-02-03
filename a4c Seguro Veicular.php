<?php
/**
* a4c Seguro Veicular
*
* Plugin Name: a4c Seguro Veicular
* Plugin URI: https://#
* Description: Este plugin verifica o valor do veiculo através da tabela FIPE e de acordo com o valor do mesmo, trás opções de proteção oferecido e previamente cadastrado pelo administrador da seguradora.
* Version: 1.0.0
* Author: Dyego Pimentel
* License: GPLv2 or Later
* Text Domain: a4c Seguro Veicular
*
* Com este plugin, o cliente pode verificar as opções e valores de proteção ideais para seu veiculo. Pode também baixar sua cotação e/ou entrar em contato com um representante através do whatsapp.
*
**/

// Verifica se o plugin foi devidamente carregado.
if (! defined('ABSPATH')){
    die('Invalid request.');
}

// Link 
define ('A4C_DIR',plugin_dir_path(__FILE__));
require_once(A4C_DIR . 'inc/admin.php');
require_once(A4C_DIR . 'inc/category.php');
require_once(A4C_DIR . 'inc/custom_post.php');
require_once(A4C_DIR . 'inc/meta_box.php');

setlocale(LC_MONETARY, 'pt_BR'); // Configura o valor da moeda.


class A4C_Seguro_Veicular {
    public function __construct() {
        //add_action( 'admin_menu', 'A4C_menu_admin' ); // Ação de cria o Menu no Painel de Admin
        //add_action('init', 'A4C_insert_table_database_SV'); // Cria o banco de dados.
        // add_action('init', 'A4C_create_categories');
        
        
    }

    public function activate() {
        

    }

    public function deactivate() {
        // A função abaixo deve ser realocada para a função uninstall, após o termino da fase de teste.
        A4C_delete_table_database_SV(); // Deleta o banco de dados.
        A4C_delete_categories(); // Deleta todas as categorias criadas ao desinstalar.

    }

    public function uninstall() {
        

    }
}

if (class_exists('A4C_Seguro_Veicular')){
    $a4cModulo = new A4C_Seguro_Veicular();
    register_activation_hook(__FILE__, array($a4cModulo,'activate'));
    register_deactivation_hook(__FILE__, array($a4cModulo,'deactivate'));
    //register_uninstall_hook(__FILE__, array($a4cModulo,'uninstall'));

}