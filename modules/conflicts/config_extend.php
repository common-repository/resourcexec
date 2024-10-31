<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$after['model/manager@conflicts'] = 'model/overlap@conflicts';
$after['view/index@prepare-view'] = 'view/overlap@extend-prepare-view';