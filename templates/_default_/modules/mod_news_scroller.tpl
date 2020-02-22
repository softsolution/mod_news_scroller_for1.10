<link rel="stylesheet" type="text/css" href="/templates/_default_/css/amazon_scroller.css" />
<script type="text/javascript" src="/templates/_default_/js/amazon_scroller.js"></script>

    <div id="scroller{$mid}" class="amazon_scroller">
        <div class="amazon_scroller_mask">
            <ul>
                {foreach key=aid item=article from=$articles}
                <li>
                    <div class="image">
                        <a href="{$article.url}" title="{$article.title|escape:'html'}">
                            <img src="/images/photos/small/{$article.image}" width="{$cfg.scroller_images_width}" height="{$cfg.scroller_images_height}" alt="{$article.title|escape:'html'}" border="0" />
                        </a>
                            <div class="slidehover">
                                <a href="{$article.url}" class="slidetitle">{$article.title|escape:'html'}</a>
                                {$article.slidetext}
                                Отзывов {$article.comments}
                            </div>
                    </div>
                </li>
                {/foreach}
            </ul>
        </div>
        <ul class="amazon_scroller_nav">
            <li></li>
            <li></li>
        </ul>
        <div style="clear: both"></div>
    </div>

{* amazon scroller init params *}
{literal}
    <script language="javascript" type="text/javascript">
        $(function() {
            
            var width = {/literal}{$cfg.scroller_images_width}{literal};
            var height = {/literal}{$cfg.scroller_images_height}{literal};
            
            $("#scroller{/literal}{$mid}{literal}").amazon_scroller({
                scroller_title_show: 'disable',
                scroller_time_interval: '{/literal}{$cfg.scroller_time_interval}{literal}',
                scroller_window_background_color: "none",
                scroller_window_padding: '10',
                scroller_border_size: '0',
                scroller_border_color: '#CCC',
                scroller_images_width: width,
                scroller_images_height: height,
                scroller_title_size: '12',
                scroller_title_color: 'black',
                scroller_show_count: '{/literal}{$cfg.scroller_show_count}{literal}',
                directory: 'images'
            });
              
            $("#scroller{/literal}{$mid}{literal} .image").hover(
                
            function(){
                //страховка
                $(this).children(".slidehover").css('bottom', '-'+height+'px');
                $(this).children(".slidehover").show().animate({bottom:'+='+height+'px'}, "fast");
            },
            function(){
                $(this).children(".slidehover").animate({bottom:'-='+height+'px'}, "fast");
            });
                
        });
    </script>
{/literal}

{* !внимание чтобы стили пересеклись добавлена привязка к родительскому блоку *}
{literal}
<style>
#scroller{/literal}{$mid}{literal} .image{width:{/literal}{$cfg.scroller_images_width}px;height:{$cfg.scroller_images_height}{literal}px; display:block;}
#scroller{/literal}{$mid}{literal} .slidehover{width:{/literal}{$cfg.scroller_images_width}px;height:{$cfg.scroller_images_height}{literal}px;}
</style>
{/literal} 

{* это можно вынести в CSS *}
{literal}
<style>
.slidetitle{font-size:12px;}
.amazon_scroller .slidehover{display:none; position:absolute; background-color:#fff; bottom:-120px; z-index:999; opacity:0.8;}
</style>
{/literal}