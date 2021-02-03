<?php

// Cria as categorias necessárias. Esta função é usada ao instalar o plugin.
function A4C_create_categories() {
    wp_create_category( 'Veiculos Leves - 1000km',0 );
    wp_create_category( 'Veiculos Leves - 500km',0 );
}
// Deleta as categorias criadas. Esta função é usada ao desinstalar o plugin.
// Caso o plugin seja apenas desativado, as categorias não serão excluidas.
function A4C_delete_categories() {
    // Ao inserir o nome da categoria como parametro da função category_exists(); 
    // caso a categoria exista, retorna o ID. 
    wp_delete_category(category_exists('Veiculos Leves - 1000km'));
    wp_delete_category(category_exists('Veiculos Leves - 500km'));
}

?>