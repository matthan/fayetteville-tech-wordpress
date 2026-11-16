<?php

/**
 * Tell WordPress to also look in the 'search_keywords' post meta for search results.
 * By default, this will be title AND post meta, which we filter to OR below.
 */
//add_action( 'pre_get_posts', function( $query ) {
//	if ( $query->is_search() && $query->is_main_query() ) {
//		$query->set( 'meta_query', array(
//			array(
//				'key'     => 'search_keywords',
//				'value'   => $query->get( 's' ),
//				'compare' => 'LIKE',
//			),
//		) );
//	}
//});

/**
 * Filter the title AND post meta query to be title OR post meta
 */
//add_filter( 'solr_select_query', function( $query ){
//	$query['query'] = str_replace( 'AND((search_keywords_str:', 'OR((search_keywords_str:', $query['query'] );
//	return $query;
//});
