<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$after['/resources/model@save'] 	= 'controller/message@extend-message';
$after['/resources/model@delete']	= 'controller/message@extend-message';
