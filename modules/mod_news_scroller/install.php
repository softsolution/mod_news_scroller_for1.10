<?php
/* ****************************************************************************************** */
/* created by soft-solution.ru                                                                */
/* install.php of module mod_content_carusel InstantCMS 1.10                                      */
/* ****************************************************************************************** */

    function info_module_mod_news_scroller(){

        //Заголовок (на сайте)
        $_module['title']        = 'Скроллер новостей';

        //Название (в админке)
        $_module['name']         = 'Скроллер новостей';

        //описание
        $_module['description']  = 'Модуль Скроллер новостей';

        //ссылка (идентификатор)
        $_module['link']         = 'mod_news_scroller';

        //позиция
        $_module['position']     = 'top';

        //автор
        $_module['author']       = 'soft-solution.ru';

        //текущая версия
        $_module['version']      = '1.01';

        //
        // Настройки по-умолчанию
        //
        $_module['config'] = array();
        $_module['config']['mode']= "fromcat";
        $_module['config']['subs']= 1;
	$_module['config']['cat_id']= 1;
	$_module['config']['newscount']= 5;
        $_module['config']['scroller_time_interval'] = 3000;
        $_module['config']['scroller_show_count'] = 2;
        $_module['config']['scroller_images_width'] = 120;
        $_module['config']['scroller_images_height'] = 120;
        
        return $_module;

    }

// ========================================================================== //

    function install_module_mod_news_scroller(){

        return true;

    }

// ========================================================================== //

    function upgrade_module_mod_news_scroller(){

        return true;

    }

// ========================================================================== //

?>