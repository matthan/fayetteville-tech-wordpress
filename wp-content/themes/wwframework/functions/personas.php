<?php

function ww_personas_list_endpoint() {
    global $POST_IDS;

    return array(
        'identities' => array(
            'active_duty_military' => array(
                'label' => 'Active Duty Military',
                'topic_page_routes' => array(
                    'career_transition' => 21186,
                    'military_promotion' => 20334,
                    'online_learning_programs' => 21188,
                    'technical_certification' => 21225,
                ),
            ),
            'reservist' => array(
                'label' => 'Reservist',
                'topic_page_routes' => array(
                    'associates_degree' => 21209,
                    'career_transition' => 21207,
                    'military_promotion' => 21205,
                    'online_learning_programs' => 21203,
                    'technical_certification' => 21211,
                ),
            ),
            'veteran' => array(
                'label' => 'Veteran',
                'topic_page_routes' => array(
                    'associates_degree' => 21215,
                    'career_transition' => 21213,
                    'continuing_education' => 21220,
                    'online_learning_programs' => 21222,
                    'technical_certification' => 21218,
                ),
            ),
            'current_high_school_student' => array(
                'label' => 'Current High School Student',
                'topic_page_routes' => array(
                    '4_year_transfer_programs' => 21282,
                    'associates_degree' => 20375,
                    'high_school_connections_credits' => 21277,
                    'online_learning_programs' => 21293,
                    'technical_certification' => 21291,
                ),
            ),
            'recent_high_school_student' => array(
                'label' => 'Recent High School Student',
                'topic_page_routes' => array(
                    '4_year_transfer_programs' => 21295,
                    'associates_degree' => 21311,
                    'career_transition' => 21308,
                    'continuing_education' => 21317,
                    'online_learning_programs' => 21325,
                    'technical_certification' => 21313,
                ),
            ),
            'working_parent' => array(
                'label' => 'Working Parent',
                'topic_page_routes' => array(
                    '4_year_transfer_programs' => 21342,
                    'associates_degree' => 21334,
                    'career_transition' => 21328,
                    'continuing_education' => 21338,
                    'online_learning_programs' => 21340,
                    //'technical_certification' => 00000,
                ),
            ),
            'mid_career' => array(
                'label' => 'Mid Career',
                'topic_page_routes' => array(
                    '4_year_transfer_programs' => 21374,
                    'associates_degree' => 21366,
                    'career_transition' => 21360,
                    'continuing_education' => 21368,
                    'online_learning_programs' => 21372,
                    'technical_certification' => 21370,
                ),
            ),
        ),
        'topics' => array(
            'military_promotion' => array(
                'label' => 'Military Promotion',
            ),
            'career_transition' => array(
                'label' => 'Career Transition',
            ),
            '4_year_transfer_programs' => array(
                'label' => '4-Year Transfer Programs',
            ),
            'associates_degree' => array(
                'label' => 'Associates Degree',
            ),
            'technical_certification' => array(
                'label' => 'Technical Certification',
            ),
            'continuing_education' => array(
                'label' => 'Continuing Education',
            ),
            'online_learning_programs' => array(
                'label' => 'Online Learning Programs',
            ),
            'high_school_connections_credits' => array(
                'label' => 'HS Connections Credits',
            ),
        ),
    );
}

// Endpoint route: /wp-json/personas/v1/list
add_action('rest_api_init', function() {
    register_rest_route('personas/v1', '/all', array(
        'methods' => 'GET',
        'callback' => 'ww_personas_list_endpoint',
    ));
});


// Set up ability to get permalink via AJAX call
function ww_ajax_get_permalink() {
    echo get_permalink(intval($_REQUEST['id']));
    die();
}
add_action('wp_ajax_get_permalink', 'ww_ajax_get_permalink');
add_action('wp_ajax_nopriv_get_permalink', 'ww_ajax_get_permalink');
