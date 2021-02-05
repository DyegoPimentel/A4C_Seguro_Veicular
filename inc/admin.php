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
    $table_post = $wpdb->prefix . 'posts';
    
    $the_removal_query = "DROP TABLE IF EXISTS {$table_name}";
 
    $wpdb->query( $the_removal_query );

    $wpdb->query("DELETE FROM $table_post WHERE post_type = 'seguro_veicular';" );
    
}




//function A4C_check_for_similar_meta_ids() {
//    $id_arrays_in_cpt = array();
//
//    $args = array(
//        'post_type'      => 'seguro_veicular',
//        'posts_per_page' => -1,
//    );
//
//    $loop = new WP_Query($args);
//    while( $loop->have_posts() ) {
//        $loop->the_post();
//        $id_arrays_in_cpt[] = get_post_meta( get_the_ID(), 'id', true );
//    }
//
//    return $id_arrays_in_cpt;
//}

//function A4C_query_SV_table( $car_available_in_cpt_array ) {
//    global $wpdb;
//    $table_name = $wpdb->prefix . 'A4C_Seguro_Veicular';
//
//    if ( NULL === $car_available_in_cpt_array || 0 === $car_available_in_cpt_array || '0' === $car_available_in_cpt_array || empty( $car_available_in_cpt_array ) ) {
//        $results = $wpdb->get_results("SELECT * FROM $table_name");
//        return $results;
//    } else {
//        $ids = implode( ",", $car_available_in_cpt_array );
//        //var_dump($ids);
//        //die;
//        $sql = "SELECT * FROM $table_name WHERE id NOT IN ( $ids )";
//        $results = $wpdb->get_results( $sql );
//        return $results;
//    }
//}

// REMOVER ESSA FUNÇÃO?
//function A4C_insert_into_auto_cpt() {
//
//    $car_available_in_cpt_array = A4C_check_for_similar_meta_ids();
//    $database_results = A4C_query_SV_table( $car_available_in_cpt_array );
//
//    if ( NULL === $database_results || 0 === $database_results || '0' === $database_results || empty( $database_results ) ) {
//        return;
//    }
//
//    foreach ( $database_results as $result ) {
//        $preco_tabela = array(
//            'post_title' => wp_strip_all_tags( ' De R$' . $result->valor_minimo . ' a R$' . $result->valor_maximo),
//            'meta_input' => array(
//                'id'        => $result->id,
//                'cota'        => $result->cota,
//                'valor_minimo'        => $result->valor_minimo,
//                'valor_maximo'        => $result->valor_maximo,
//                'valor_24h_plano_ppv'           => $result->valor_24h_plano_ppv,
//                'fundo_tercerio_30k' => $result->fundo_tercerio_30k,
//                'fundo_tercerio_50k' => $result->fundo_tercerio_50k,
//                'fundo_tercerio_70k' => $result->fundo_tercerio_70k,
//                'reserva_15_dias' => $result->reserva_15_dias,
//                'reserva_30_dias' => $result->reserva_30_dias,
//                'protecao_vidros_70' => $result->protecao_vidros_70,
//                'app_bronze' => $result->app_bronze,
//                'app_prata' => $result->app_prata,
//                'plataforma_rastreador' => $result->plataforma_rastreador,
//                'adesao' => $result->adesao,
//                'rastreador' => $result->rastreador,
//                'cota_participacao' => $result->cota_participacao,
//                'categoria' => $result->categoria,
//            ),
//            'post_type'   => 'seguro_veicular',
//            'post_status' => 'publish',
//        );
//        wp_insert_post( $preco_tabela );
//    }
//}

// Ao Inserir

//function A4C_create_cpt() {
//    global $wpdb; // Acessa o banco de dados.
//    $table_name = $wpdb->prefix . 'A4C_Seguro_Veicular'; // Escreve o nome da tabela.
//
//
//    // Verifica se é o Custom Post Type Correto.
//    global $post;
//    if ($_GET['post_type'] != 'seguro_veicular'){
//        return;
//    }else {
//        $sql = "SELECT id FROM $table_name ORDER BY id DESC LIMIT 1;";
//        $results = $wpdb->get_results( $sql );
//        if (empty($results)) {
//            $incremented_id = 1;
//            $data = array('id' => $incremented_id);
//            $wpdb->insert( $table_name, $data );
//            
//        } else {
//            $incremented_id = intval($results[0]->id) + 1;
//        }
//        //var_dump($incremented_id);
//        //die;
//
//        $lastrowId=$wpdb->get_col( "SELECT ID FROM wp_posts where post_type='seguro_veicular' ORDER BY post_date DESC LIMIT 1;" );
//
//        $teste = intval($lastPropertyId=$lastrowId[0]) + 1;
//
//        update_post_meta( $teste, 'id', $incremented_id);
//    }
//
//
//
//
//}

// Ao Publicar
//function A4C_publish_cpt() {
//    global $wpdb; // Acessa o banco de dados.
//    $table_name = $wpdb->prefix . 'A4C_Seguro_Veicular'; // Escreve o nome da tabela.
//
//    $sql = "SELECT id FROM $table_name ORDER BY id DESC LIMIT 1;";
//    $results = $wpdb->get_results( $sql );
//    $incremented_id = intval($results[0]->id) + 1;
//    
//    $data = array('id' => $incremented_id);
//    $wpdb->insert( $table_name, $data );
//}

//Save Metabox Value
//function A4C_save_meta_box($post_id){
//    global $wpdb; // Acessa o banco de dados.
//    $table_name = $wpdb->prefix . 'A4C_Seguro_Veicular'; // Escreve o nome da tabela.
//    
//    if ($post_id === false) { // Se não tiver o Id do post.
//        return;
//    }else { // Se tiver o Id do post.
//        $post_id = get_the_ID(); // Pega o Id do post
//        $category = get_the_category($post_id); // Verifica qual é a categoria do post;
//
//        if(empty($category) || NULL === $category || 0 === $category || '0' === $category) {
//            $category = NULL; // Se a categoria estiver vazia, não retorna nada e grava null no db.            
//        } else {
//            $category = $category[0]->name; // Se a categoria não estiver vazia, retorna a string com o nome da categoria.
//        }
//        
//
//    // Verifica se valores foram passados e atualiza o titulo.
//
//    // Se nao tiver dados, zera os valores.
//    if (empty($_POST)) {
//        $valor_minimo = 0;
//        $valor_maximo = 0;
//    } else {
//        $valor_minimo = number_format(floatval($_POST['valor_minimo_a4c_meta_box']),2,',','.');
//        $valor_maximo = number_format(floatval($_POST['valor_maximo_a4c_meta_box']),2,',','.');
//    }
//
//    if ( NULL !== ($valor_minimo && $valor_maximo)) { // Não é NULL
//        // Se o valor maximo for 0, registra post type como rascunho.
//        if (0 === $valor_maximo || '0' === $valor_maximo || Null === $valor_maximo || empty($valor_maximo)) {
//            $update_title = array(
//                'ID'           => $post_id,
//                'post_title'   => wp_strip_all_tags( ' De R$' . $valor_minimo . ' a R$' . $valor_maximo),
//                'post_type'   => 'seguro_veicular',
//                'post_status' => 'draft',
//            );
//            wp_update_post( $update_title );
//        } else { // se não, registra como publicado.
//            $update_title = array(
//                'ID'           => $post_id,
//                'post_title'   => wp_strip_all_tags( ' De R$' . $valor_minimo . ' a R$' . $valor_maximo),
//            );
//            wp_update_post( $update_title );
//        }
//    } else {
//        echo "valores não existem";
//        die;
//    }
//
//
//        
//        //die;
//        
//    }
//    // Verifica se é o Custom Post Type Correto.
//    global $post;
//    if ($post->post_type != 'seguro_veicular'){
//        return;
//    }
//
//    // Verifica o auto save.
//    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
//        return;
//    }
//
//
//    //if ( isset($_POST['first_name_meta_box_nonce']) && ! wp_verify_nonce( $_POST['first_name_meta_box_nonce'], 'first_name' ) ) {
//    //    return;
//    //}
//
//
//
//
//    if(!isset($_POST["id_a4c_meta_box"])){
//        echo "Id não inserido, Entre em contato com o Desenvolvedor!";
//        die;        
//    }else {
//        // Atualiza dados do meta no banco de dados
//        $wpdb->update( 
//            $table_name, 
//            array( 
//                'categoria' => $category,
//                'cota' => $_POST['cota_a4c_meta_box'],
//                'valor_minimo' => $_POST['valor_minimo_a4c_meta_box'],
//                'valor_maximo' => $_POST['valor_maximo_a4c_meta_box'],
//                'valor_24h_plano_ppv' => $_POST['24h_ppv_a4c_meta_box'],
//                'fundo_tercerio_30k' => $_POST['fundo_tercerio_30k_a4c_meta_box'],
//                'fundo_tercerio_50k' => $_POST['fundo_tercerio_50k_a4c_meta_box'],
//                'fundo_tercerio_70k' => $_POST['fundo_tercerio_70k_a4c_meta_box'],
//                'reserva_15_dias' => $_POST['reserva_15_dias_a4c_meta_box'],
//                'reserva_30_dias' => $_POST['reserva_30_dias_a4c_meta_box'],
//                'protecao_vidros_70' => $_POST['protecao_vidros_70_a4c_meta_box'],
//                'app_bronze' => $_POST['app_bronze_a4c_meta_box'],
//                'app_prata' => $_POST['app_prata_a4c_meta_box'],
//                'plataforma_rastreador' => $_POST['plataforma_rastreador_a4c_meta_box'],
//                'adesao' => $_POST['adesao_a4c_meta_box'],
//                'rastreador' => $_POST['rastreador_a4c_meta_box'],
//                'cota_participacao' => $_POST['cota_participacao_a4c_meta_box']                
//            ), 
//            array( 'id' => $_POST['id_a4c_meta_box'] ) 
//        );
//
//        //FALTA FINALIZAR OS UPDATES ABAIXO.
//        update_post_meta( $post_id, 'categoria', $category);
//        update_post_meta( $post_id, 'cota', $_POST['cota_a4c_meta_box']);
//        update_post_meta( $post_id, 'valor_minimo', $_POST['valor_minimo_a4c_meta_box']);
//    }
//
//
//    //update_post_meta( $post_id, 'categoria', $category);
//    //update_post_meta( $post_id, 'categoria', $category);
//    //update_post_meta( $post_id, 'categoria', $category);
//    //update_post_meta( $post_id, 'categoria', $category);
//    //update_post_meta( $post_id, 'categoria', $category);
//    //update_post_meta( $post_id, 'categoria', $category);
//    //update_post_meta( $post_id, 'categoria', $category);
//    //update_post_meta( $post_id, 'categoria', $category);
//    //update_post_meta( $post_id, 'categoria', $category);
//   // update_post_meta( $post_id, 'categoria', $category); // atualiza a categoria no metabox
//
//   // print_r($_POST['valor_minimo_a4c_meta_box']);
//   // die;
//}
?>