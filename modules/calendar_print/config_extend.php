<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$before['/calendar/view/menubar@render'] = 'view/menubar@remove-menubar';
$after['/calendar/view/header@render'] = 'view/header@extend-render';
