<?php
/* ****************************************************************************************** */
/* created by soft-solution.ru                                                                */
/* module.php of module mod_content_carusel InstantCMS 1.10                                   */
/* ****************************************************************************************** */

function mod_news_scroller($module_id){

	$inCore = cmsCore::getInstance();
	$inDB   = cmsDatabase::getInstance();

	$inCore->loadModel('content');
	$model = new cms_model_content();

	$cfg = $inCore->loadModuleConfig($module_id);
        
        if (!isset($cfg['mode'])) { $cfg['mode'] = "fromcat"; }
	if (!isset($cfg['subs'])) { $cfg['subs'] = 1; }
	if (!isset($cfg['cat_id'])) { $cfg['cat_id'] = 1; }
	if (!isset($cfg['newscount'])) { $cfg['newscount'] = 5; }
        if (!isset($cfg['scroller_time_interval'])) { $cfg['scroller_time_interval'] = 3000; }
        if (!isset($cfg['scroller_show_count'])) { $cfg['scroller_show_count'] = 2; }
        if (!isset($cfg['scroller_images_width'])) { $cfg['scroller_images_width'] = 120; }
        if (!isset($cfg['scroller_images_height'])) { $cfg['scroller_images_height'] = 120; }
        
        if($cfg['mode']=="fromcat"){

            if($cfg['cat_id']){
                if (!$cfg['subs']){
                    //выбираем из категории
                    $model->whereCatIs($cfg['cat_id']);
                } else {
                    //выбираем из категории и подкатегорий
                    $rootcat = $inDB->getNsCategory('cms_category', $cfg['cat_id']);
                    if(!$rootcat) { return false; }
                    $model->whereThisAndNestedCats($rootcat['NSLeft'], $rootcat['NSRight']);
                }
            }
        
            $inDB->orderBy('con.pubdate', 'DESC');
            $inDB->limitPage(1, $cfg['newscount']);

            $content_list = $model->getArticlesList();
            
        } else {
            //выбор статей по id

            //prepare ids
            $ids = array();

            if (!strstr($cfg['ids'], ',')){
                // указан один id
                $ids[] = $cfg['ids'];
            } else {
                // указано несколько id через запятую
                $ids = explode(',', $cfg['ids']);
            }

            foreach($ids as $id){
                $id = trim($id);
                $ids_sql .= $id.", ";
            }

            $ids_sql =  substr($ids_sql, 0, -2);
            
            $today = date("Y-m-d H:i:s");
            
            $sql = "SELECT con.*, con.pubdate as fpubdate, cat.title as cat_title, cat.seolink as catseolink, cat.showdesc, u.nickname as author, u.login as user_login
                    FROM cms_content con
                    INNER JOIN cms_category cat ON cat.id = con.category_id
                    LEFT JOIN cms_users u ON u.id = con.user_id
                    WHERE con.is_arhive = 0";
            $sql .= " AND con.published = 1 AND con.pubdate <= '$today' AND (con.is_end=0 OR (con.is_end=1 AND con.enddate >= '$today'))";
            $sql .= " AND con.id IN ($ids_sql)";
            $sql .= " LIMIT ".$cfg['newscount'];
            $result = $inDB->query($sql);
            
            if ($inDB->num_rows($result)){	
			
                while($article = $inDB->fetch_assoc($result)){
                        $article['fpubdate'] = cmsCore::dateFormat($article['fpubdate']);
                        $article['url']      = $model->getArticleURL(null, $article['seolink']);
                        $article['cat_url']  = $model->getCategoryURL(null, $article['catseolink']);
                        $article['image']    = (file_exists(PATH.'/images/photos/small/article'.$article['id'].'.jpg') ? 'article'.$article['id'].'.jpg' : '');

                        $content_list[] = $article;
                }
			
            }
            
        }
        
        if(!$content_list) { return false; }

        //обработка массива
        $articles = array();
        foreach($content_list as $key=>$article){
            $articles[$key]['url']      = $article['url'];
            $articles[$key]['title']    = $article['title'];
            $articles[$key]['image']    = $article['image'];
            $articles[$key]['comments'] = $article['comments'];
            if (preg_match('|<div id="experience">(.*)</div>|sei', $article['description'], $arr)) {
                $articles[$key]['slidetext'] = $arr[1];
            } else {
                $articles[$key]['slidetext'] = "";
            }
        }

        $smarty = $inCore->initSmarty('modules', 'mod_news_scroller.tpl');
	$smarty->assign('articles', $articles);
	$smarty->assign('mid', $module_id);
	$smarty->assign('cfg', $cfg);
	$smarty->display('mod_news_scroller.tpl');			

	return true;

}
?>