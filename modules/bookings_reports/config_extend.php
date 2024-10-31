<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$after['/reports/report/utilization@prepare-header']	= 'report/utilization@extend-prepare-header';
$after['/reports/report/utilization@prepare-rows']		= 'report/utilization@extend-prepare-rows';
$after['/reports/report/utilization@prepare-sort']		= 'report/utilization@extend-prepare-sort';