<?php

// Cria as categorias necessárias. Esta função é usada ao instalar o plugin.
function A4C_create_categories() {
    wp_create_category( 'Veiculos Leves - 400km',0 );
    wp_create_category( 'Veiculos Leves - 1000km',0 );
    wp_create_category( 'Pick-up/SUV - 400km',0 ); 
    wp_create_category( 'Pick-up/SUV - 1000km',0 );     
    wp_create_category( 'Motocicletas - 300km',0 );
    wp_create_category( 'Motocicletas - 600km',0 );
    wp_create_category( 'Vans e Microonibus - 300km',0 );
    wp_create_category( 'Vans e Microonibus - 500km',0 );
}
// Deleta as categorias criadas. Esta função é usada ao desinstalar o plugin.
// Caso o plugin seja apenas desativado, as categorias não serão excluidas.
function A4C_delete_categories() {
    // Ao inserir o nome da categoria como parametro da função category_exists(); 
    // caso a categoria exista, retorna o ID. 
    wp_delete_category(category_exists('Veiculos Leves - 400km'));
    wp_delete_category(category_exists('Veiculos Leves - 1000km'));
    wp_delete_category(category_exists('Pick-up/SUV - 1000km'));
    wp_delete_category(category_exists('Pick-up/SUV - 400km'));    
    wp_delete_category(category_exists('Motocicletas - 300km'));
    wp_delete_category(category_exists('Motocicletas - 600km'));
    wp_delete_category(category_exists('Vans e Microonibus - 300km'));
    wp_delete_category(category_exists('Vans e Microonibus - 500km'));
}

?>