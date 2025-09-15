<?php
/**
 * Taxonomy: Project Category
 * Reuse the Projects archive template so filters, cards, and styling match.
 */
if ( ! defined('ABSPATH') ) exit;

// Delegate everything to the archive template (it already handles term context)
require_once get_template_directory() . '/archive-project.php';