<?php

// Cria a tabela no banco de dados ao iniciar o plugin.
function A4C_insert_table_database_SV() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'A4C_Seguro_Veicular';
    $wpdb_collate = $wpdb->collate;

    //PRECISA VERIFICAR ESTE SQL
    $sql =
        "CREATE TABLE {$table_name} (
        id mediumint(8) unsigned NOT NULL auto_increment ,
        cota float,
        valor_minimo float,
        valor_maximo float,
        valor_24h_plano_ppv float,
        fundo_tercerio_30k float,
        fundo_tercerio_50k float,
        fundo_tercerio_70k float,
        reserva_15_dias float,
        reserva_30_dias float,
        protecao_vidros_70 float,
        app_bronze float,
        app_prata float,
        plataforma_rastreador float,
        adesao float,
        rastreador float,
        cota_participacao float,
        categoria varchar(255),       
        PRIMARY KEY  (id)
        )
        COLLATE {$wpdb_collate}";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sql );
}

// Função para excluir tabela do banco de dados ao remover o plugin.
function A4C_delete_table_database_SV() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'A4C_Seguro_Veicular';
    $the_removal_query = "DROP TABLE IF EXISTS {$table_name}";
 
    $wpdb->query( $the_removal_query );
}

// Cria as categorias necessárias. Esta função é usada ao instalar o plugin.
function A4C_create_categories() {
    wp_create_category( 'Veiculos Leves - 1000km' );
    wp_create_category( 'Veiculos Leves - 500km' );
}
// Deleta as categorias criadas. Esta função é usada ao desinstalar o plugin.
// Caso o plugin seja apenas desativado, as categorias não serão excluidas.
function A4C_delete_categories() {
    // Ao inserir o nome da categoria como parametro da função category_exists(); 
    // caso a categoria exista, retorna o ID. 
    wp_delete_category(category_exists('Veiculos Leves - 1000km'));
    wp_delete_category(category_exists('Veiculos Leves - 500km'));
}

// Register Custom Post Type
function create_A4C_SV_cpt() {

	$labels = array(
		'name'                  => _x( 'Tabela de Preço', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Tabela de Preço', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Preços', 'text_domain' ),
		'name_admin_bar'        => __( 'Preços', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Tabela de Preços', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Adicionar Novo Preço', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Pesquisar', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Tabela de Preço', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'taxonomies'            => array( 'category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-welcome-widgets-menus',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'Seguro_veicular_CPT', $args );

}
add_action( 'init', 'create_A4C_SV_cpt', 0 );
add_action( 'admin_init', 'my_admin' );

function my_admin() {
    add_meta_box( 
        'precos_meta_box', // ID
        'Informações desta faixa de preço', // Descrição
        'display_precos_meta_box', // Função
        'Seguro_veicular_CPT', // Registro do CPT
        'normal',
        'high'
    );
}

function display_precos_meta_box_OLD() {
    ?>
    <table>   
    
        <tr>
            <td style="width: 50%">ID</td>
            <td><input type="text" size="40" name="id_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'id', true ); ?>" readonly /></td>
        </tr>
        <tr>
            <td style="width: 50%">Categoria</td>
            <td><input type="text" size="40" name="categoria_meta_box_select" value="<?php echo get_post_meta( get_the_ID(), 'categoria', true ); ?>" readonly /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Cota</td>
            <td><input type="text" size="40" name="cota_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'cota', true ); ?>" /></td>
        </tr>
        <tr>
            <td style="width: 50%">Valor Mínimo</td>
            <td><input type="text" size="40" name="valor_minimo_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'valor_minimo', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Valor Máximo</td>
            <td><input type="text" size="40" name="valor_maximo_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'valor_maximo', true ); ?>" /></td>
        </tr>
        <tr>
            <td style="width: 50%">Valor 24H + Plano PPV</td>
            <td><input type="text" size="40" name="24h_ppv_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'valor_24h_plano_ppv', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Fundo para terceiro - 30 Mil</td>
            <td><input type="text" size="40" name="terceiro_30k_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'fundo_tercerio_30k', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Fundo para terceiro - 50 Mil</td>
            <td><input type="text" size="40" name="terceiro_50k_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'fundo_tercerio_50k', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Fundo para terceiro - 70 Mil</td>
            <td><input type="text" size="40" name="terceiro_70k_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'fundo_tercerio_70k', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Veiculo reserva - 15 dias</td>
            <td><input type="text" size="40" name="reserva_15_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'reserva_15_dias', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Veiculo reserva - 30 dias</td>
            <td><input type="text" size="40" name="reserva_30_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'reserva_30_dias', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Proteção de vidros - 70%</td>
            <td><input type="text" size="40" name="protecao_vidros_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'protecao_vidros_70', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">App Bronze até 10 mil</td>
            <td><input type="text" size="40" name="app_bronze_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'app_bronze', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">App Prata até 20 mil</td>
            <td><input type="text" size="40" name="app_prata_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'app_prata', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Acesso plataforma/rastreador</td>
            <td><input type="text" size="40" name="plataforma_rastreador_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'plataforma_rastreador', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Adesão</td>
            <td><input type="text" size="40" name="adesao_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'adesao', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Rastreador</td>
            <td><input type="text" size="40" name="rastreador_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'rastreador', true ); ?>" /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Cota de participação</td>
            <td><input type="text" size="40" name="cota_participacao_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'cota_participacao', true ); ?>" /></td>       
        </tr>


    </table>
    
    <?php
}

function display_precos_meta_box() {
    ?>
    <form method="post">   
        <div class="input-group" style="width: 50%">
            <label class="input-group">ID</label><br>
            <input type="text" size="40" class="form-control" name="id_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'id', true ); ?>" readonly />
        </div>
        <div class="input-group" style="width: 50%">
            <label>Categoria</label><br>
            <input type="text" size="40" class="form-control" name="categoria_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'categoria', true ); ?>" readonly />       
        </div>
        <div class="input-group">
            <label>Cota</label><br>
            <input type="text" size="40" class="form-control" name="cota_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'cota', true ); ?>" />
        </div>
        <div class="input-group">
            <label>Valor Mínimo</label><br>
            <input type="text" size="40" class="form-control" name="valor_minimo_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'valor_minimo', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>Valor Máximo</label><br>
            <input type="text" size="40" class="form-control" name="valor_maximo_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'valor_maximo', true ); ?>" />
        </div>
        <div class="input-group">
            <label>Valor 24H + Plano PPV</label><br>
            <input type="text" size="40" class="form-control" name="24h_ppv_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'valor_24h_plano_ppv', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>Fundo para terceiro - 30 Mil</label><br>
            <input type="text" size="40" class="form-control" name="terceiro_30k_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'fundo_tercerio_30k', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>Fundo para terceiro - 50 Mil</label><br>
            <input type="text" size="40" name="terceiro_50k_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'fundo_tercerio_50k', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>Fundo para terceiro - 70 Mil</label><br>
            <input type="text" size="40" class="form-control" name="terceiro_70k_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'fundo_tercerio_70k', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>Veiculo reserva - 15 dias</label><br>
            <input type="text" size="40" class="form-control" name="reserva_15_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'reserva_15_dias', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>Veiculo reserva - 30 dias</label><br>
            <input type="text" size="40" class="form-control" name="reserva_30_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'reserva_30_dias', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>Proteção de vidros - 70%</label><br>
            <input type="text" size="40" class="form-control" name="protecao_vidros_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'protecao_vidros_70', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>App Bronze até 10 mil</label><br>
            <input type="text" size="40" class="form-control" name="app_bronze_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'app_bronze', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>App Prata até 20 mil</label><br>
            <input type="text" size="40" class="form-control" name="app_prata_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'app_prata', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>Acesso plataforma/rastreador</label><br>
            <input type="text" size="40" class="form-control" name="plataforma_rastreador_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'plataforma_rastreador', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>Adesão</label><br>
            <input type="text" size="40" class="form-control" name="adesao_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'adesao', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>Rastreador</label><br>
            <input type="text" size="40" class="form-control" name="rastreador_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'rastreador', true ); ?>" />       
        </div>
        <div class="input-group">
            <label>Cota de participação</label><br>
            <input type="text" size="40" class="form-control" name="cota_participacao_a4c_meta_box" value="<?php echo get_post_meta( get_the_ID(), 'cota_participacao', true ); ?>" />       
        </div>
    </form>
    
    <?php
}



function A4C_check_for_similar_meta_ids() {
    $id_arrays_in_cpt = array();

    $args = array(
        'post_type'      => 'Seguro_veicular_CPT',
        'posts_per_page' => -1,
    );

    $loop = new WP_Query($args);
    while( $loop->have_posts() ) {
        $loop->the_post();
        $id_arrays_in_cpt[] = get_post_meta( get_the_ID(), 'id', true );
    }

    return $id_arrays_in_cpt;
}

function A4C_query_SV_table( $car_available_in_cpt_array ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'A4C_Seguro_Veicular';

    if ( NULL === $car_available_in_cpt_array || 0 === $car_available_in_cpt_array || '0' === $car_available_in_cpt_array || empty( $car_available_in_cpt_array ) ) {
        $results = $wpdb->get_results("SELECT * FROM $table_name");
        return $results;
    } else {
        $ids = implode( ",", $car_available_in_cpt_array );
        $sql = "SELECT * FROM $table_name WHERE id NOT IN ( $ids )";
        $results = $wpdb->get_results( $sql );
        return $results;
    }
}

function A4C_insert_into_auto_cpt() {

    $car_available_in_cpt_array = A4C_check_for_similar_meta_ids();
    $database_results = A4C_query_SV_table( $car_available_in_cpt_array );

    if ( NULL === $database_results || 0 === $database_results || '0' === $database_results || empty( $database_results ) ) {
        return;
    }

    foreach ( $database_results as $result ) {
        $preco_tabela = array(
            'post_title' => wp_strip_all_tags( ' De R$' . $result->valor_minimo . ' a R$' . $result->valor_maximo),
            'meta_input' => array(
                'id'        => $result->id,
                'cota'        => $result->cota,
                'valor_minimo'        => $result->valor_minimo,
                'valor_maximo'        => $result->valor_maximo,
                'valor_24h_plano_ppv'           => $result->valor_24h_plano_ppv,
                'fundo_tercerio_30k' => $result->fundo_tercerio_30k,
                'fundo_tercerio_50k' => $result->fundo_tercerio_50k,
                'fundo_tercerio_70k' => $result->fundo_tercerio_70k,
                'reserva_15_dias' => $result->reserva_15_dias,
                'reserva_30_dias' => $result->reserva_30_dias,
                'protecao_vidros_70' => $result->protecao_vidros_70,
                'app_bronze' => $result->app_bronze,
                'app_prata' => $result->app_prata,
                'plataforma_rastreador' => $result->plataforma_rastreador,
                'adesao' => $result->adesao,
                'rastreador' => $result->rastreador,
                'cota_participacao' => $result->cota_participacao,
                'categoria' => $result->categoria,
            ),
            'post_type'   => 'Seguro_veicular_CPT',
            'post_status' => 'publish',
        );
        wp_insert_post( $preco_tabela );
    }
}

// Inserir e Atualizar Metabox


//Save Hook
add_action( 'save_post', 'A4C_save_meta_box' );

//Save Metabox Value
function A4C_save_meta_box($post_id){
    global $wpdb; // Acessa o banco de dados.
    $table_name = $wpdb->prefix . 'A4C_Seguro_Veicular'; // Escreve o nome da tabela.
    
    $post_id = get_the_ID(); // Pega o Id do post
    $category = get_the_category($post_id); // Verifica qual é a categoria do post;
    $category = $category[0]->name; // Retorna a string com o nome da categoria.

    //you might want this or not
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    //if ( isset($_POST['first_name_meta_box_nonce']) && ! wp_verify_nonce( $_POST['first_name_meta_box_nonce'], 'first_name' ) ) {
    //    return;
    //}



    //if(!isset($_POST["fname"])){
    //return;

    //}


    $wpdb->update( 
        $table_name, 
        array( 
            'categoria' => $category,   // string
            'valor_minimo' => $_POST['valor_minimo_a4c_meta_box']    // integer (number) 
        ), 
        array( 'id' => $_POST['id_a4c_meta_box'] ) 
    );

   // update_post_meta( $post_id, 'categoria', $category); // atualiza a categoria no metabox

   // print_r($_POST['valor_minimo_a4c_meta_box']);
   // die;
}


?>