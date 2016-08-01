<?php

if (!function_exists('create_breadcrumb')) {

    function create_breadcrumb() {
        $ci = &get_instance();
        $i = 1;
        $uri = $ci->uri->segment($i);
        $link = '<ul class="breadcrumb1"><li>You are here:</li>';
        $link.='<li><a title="" class="tip" href="' . base_url() . '" data-original-title="Home"><i class="s16 icomoon-icon-screen-2"></i></a></li>';

        while ($uri != '') {
            $prep_link = '';
            for ($j = 1; $j <= $i; $j++) {
                $prep_link .= $ci->uri->segment($j) . '/';
            }

            if ($ci->uri->segment($i + 1) == '') {
                if (!(int) $ci->uri->segment($i)) {
                    $link.='<span class="divider"><i class="s16 icomoon-icon-arrow-right-3"></i></span>';
                    $link.='<li>';
                    $link .= ucwords(str_replace('_', ' ', $ci->uri->segment($i))) . '</a></li> ';
                }
            } else {
                if (!is_numeric($ci->uri->segment($i))) {
                    $link.='<span class="divider"><i class="s16 icomoon-icon-arrow-right-3"></i></span>';
                    $link.='<li><a class="tip" data-original-title="' . ucwords($ci->uri->segment($i)) . '" href="' . site_url($prep_link) . '">';
                    $link .= ucwords(str_replace('_', ' ', $ci->uri->segment($i))) . '</a></li> ';
                }
            }
            $i++;
            $uri = $ci->uri->segment($i);
        }
        $link .= '</ul>';
        return $link;
    }

}

// <ul class="breadcrumb"><li>You are here:</li><li><a title="" class="tip" href="index.html" data-original-title="back to dashboard"><i class="s16 icomoon-icon-screen-2"></i></a></li><span class="divider"><i class="s16 icomoon-icon-arrow-right-3"></i></span><li>Dashboard</li></ul>