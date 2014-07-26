<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
// template init
$template = array (
        'page' => 'index',
        'title' => $tc_config ['site'] ['title'] 
);
// database
if ($tc_config ['db'] ['model'] == 'mongodb') {
    $tc_db = new MongoClient( $tc_config ['db'] ['connection'] ['uri'], $tc_config ['db'] ['connection'] ['options'] );
    $tc_coll = array (
            'users' => $tc_db->selectCollection( $tc_config ['db'] ['connection'] ['db'], $tc_config ['db'] ['collection'] ['users'] ),
            'blogs' => $tc_db->selectCollection( $tc_config ['db'] ['connection'] ['db'], $tc_config ['db'] ['collection'] ['blogs'] ) 
    );
}
$tc_cursor_posts = $tc_coll ['blogs']->find()->sort( array (
        'time' => - 1 
) )->limit( 20 );
$template ['blogs'] = iterator_to_array( $tc_cursor_posts );
// output
include_once $tc_config ['template'] . 'header.php';
include_once $tc_config ['template'] . 'index.php';
include_once $tc_config ['template'] . 'footer.php';
