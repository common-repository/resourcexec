<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$before['/html/view/*@render']		= 'view/styler@apply';
$before['/*_html/view/*@render']	= 'view/styler@apply';