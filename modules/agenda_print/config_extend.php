<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$before['/agenda/view/menubar@render'] = 'view/menubar@remove-menubar';
$after['/agenda/view/header@render'] = 'view/header@extend-render';
