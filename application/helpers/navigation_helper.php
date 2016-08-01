<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('navigation_show_hide_ul')) {

    /**
     * Navigation show hide ul
     * @param string $page
     * @param mixed $pages
     * @return string
     */
    function navigation_show_hide_ul($page, $pages) {
        $html = '';
        if (in_array($page, $pages)) {
            $html = 'class="sub show" ';
            $html .= 'style="display: block;"';
        } else {
            $html = 'class="sub"';
        }

        return $html;
    }

}

if (!function_exists('highlight_menu')) {

    /**
     * Highlight menu
     * @param string $page
     * @param mixed $pages
     * @return string
     */
    function highlight_menu($page, $pages) {
        $html = '';
        if (in_array($page, $pages)) {
            $html = ' highlight-menu';
        }

        return $html;
    }

}

if (!function_exists('exapnd_not_expand_menu')) {

    /**
     * Expand or not expand ul menu
     * @param string $page
     * @param mixed $pages
     * @return string
     */
    function exapnd_not_expand_menu($page, $pages) {
        $html = 'notExpand';
        if (in_array($page, $pages)) {
            $html = 'expand';
        }

        return $html;
    }

}

if (!function_exists('set_active_menu')) {

    /**
     * Set active menu
     * @param string $page
     */
    function set_active_menu($page) {
        $link = 'link-' . $page;
        $page = 'link-' . $page;
        if ($link == $page) {
            $html = 'class="active"';
            ?>
            <script>
                $('#<?php echo $link; ?>').addClass('active');
            </script>
            <?php
        }
    }

}

if (!function_exists('active_single_menu')) {

    /**
     * Set single menu active
     * @param string $search
     * @param string $page
     * @return string
     */
    function active_single_menu($search, $page) {
        $html = '';
        if($page == $search) {
            $html = 'class="active"';;
        } else {
            $html = '';
        }
        
        return $html;
    }

}