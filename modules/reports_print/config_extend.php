<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$before['/reports/view/menubar@render'] = 'view/menubar@remove-menubar';
$after['/reports/view/header@render'] = 'view/header@extend-render';
