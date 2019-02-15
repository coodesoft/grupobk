<?php
/**
 * Template for the secondary menu in header.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       http://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
	<div class="fusion-secondary-main-menu">
		<div class="fusion-row">
			<?php avada_main_menu(); ?>
			<?php if ( 'v4' == Avada()->settings->get( 'header_layout' ) ) : ?>
				<?php $header_content_3 = Avada()->settings->get( 'header_v4_content' ); ?>
				<?php if ( 'Tagline And Search' == $header_content_3 ) : ?>
					<div class="fusion-secondary-menu-search"><?php echo get_search_form( false ); ?></div>
				<?php elseif ( 'Search' == $header_content_3 ) : ?>
					<div class="fusion-secondary-menu-search"><?php echo get_search_form( false ); ?></div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

	<?php
	if (is_user_logged_in()) {
	    $user = wp_get_current_user();
	    if ( in_array( 'RRHH', (array) $user->roles ) ) {
	        $items = '<div class="submenu"><ul style="width:auto;max-width:1100px;margin:10px auto;display:flex;">';
	        $items .= '<li class="submenu-item"><a target="_self" rel="noopener noreferrer" href="'. home_url('/rrhh/') .' "><span class="menu-text">RRHH</span></a></li>';
	        $items .= "</ul></div>";
					$items .= "<style>@media only screen and (max-width: 800px) style.css?ver=4.9.9:1170 .post-content {  margin-top: 120px!important; }</style>";
	    } else if ( in_array( 'customer', (array) $user->roles ) ){
	    $items = '<div class="submenu"><ul style="width:auto;max-width:1100px;margin:10px auto;display:flex;">';
	    $items .= '<li class="submenu-item"><a target="_self" rel="noopener noreferrer" href="'. home_url('/noticias/') .' "><span class="menu-text">Noticias</span></a></li>';
	    $items .= '<li class="submenu-item"><a target="_self" rel="noopener noreferrer" href="'. home_url('/Descarga_nueva/') .' "><span class="menu-text">Descargas</span></a></li>';
	    $items .= '<li class="submenu-item"><a target="_self" rel="noopener noreferrer" href="'. home_url('/catalogo') .' "><span class="menu-text">Pedidos</span></a></li>';
	    $items .= '<li class="submenu-item"><a target="_self" rel="noopener noreferrer" href="'. home_url('/mi-cuenta/') .' "><span class="menu-text">Mi Cuenta</span></a></li>';
	    $items .= "</ul></div>";
			$items .= "<style>@media only screen and (max-width: 800px) {.post-content {  margin-top: 120px!important; }}</style>";
	    }

	 echo $items;
	}

	?>
	</div>
</div> <!-- end fusion sticky header wrapper -->
