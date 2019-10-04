<?php

    header('Content-Type: application/json');
    stream_context_set_default(array(
        'ssl'                => array(
        'peer_name'          => 'generic-server',
        'verify_peer'        => FALSE,
        'verify_peer_name'   => FALSE,
        'allow_self_signed'  => TRUE
    )));
    
    # Get Pillar Details
    $nidPillar  = $_GET['nid'];
    $urlPillar  = 'http://explore.php7dev.lib.ou.edu/restep/taxonomy_term/'.$nidPillar;
    $jsonPillar = file_get_contents( $urlPillar );
    $dataPillar = json_decode( $jsonPillar, TRUE);

    # Get Associated Stories
    $urlStories  = 'https://explore.php7dev.lib.ou.edu/restep/node';
    $jsonStories = file_get_contents( $urlStories );
    $dataStories = json_decode( $jsonStories, TRUE);
    $storiesArr  = array();
    foreach( $dataStories as $story ){
        $urlSingleStory  = $story['uri'];
        $jsonSingleStory = file_get_contents( $urlSingleStory );
        $dataSingleStory = json_decode( $jsonSingleStory, TRUE);
        if( $dataSingleStory['field_pillars']['und'][0]['tid'] == $nidPillar ){
            # Push story to stories array
            array_push( $storiesArr,
                array(
                    'id'    => $dataSingleStory['vid'],
                    'title' => $dataSingleStory['title'],
                    'body'  => $dataSingleStory['body']['und'][0]['value'],
                    'image' => 'https://explore.php7dev.lib.ou.edu/sites/default/files/'.$dataSingleStory['field_cover_image']['und'][0]['filename'],
                )
            ); 
        }
    }
    
    # Create array of Pillar information.
    $arr = array(
        'title' => $dataPillar['name'],
        'description' => str_replace(array("\n", "\r","\t"), '', $dataPillar['description']),
        'image' => 'https://explore.php7dev.lib.ou.edu/sites/default/files/'.$dataPillar['field_pillar_image']['und'][0]['filename'],
        'stats' => array(
            array(
                'number' => $dataPillar['field_by_the_numbers_number_1']['und'][0]['value'],
                'label'  => $dataPillar['field_by_the_numbers_label_1']['und'][0]['value']
            ),
            array(
                'number' => $dataPillar['field_by_the_numbers_number_2']['und'][0]['value'],
                'label'  => $dataPillar['field_by_the_numbers_label_2']['und'][0]['value']
            ),
            array(
                'number' => $dataPillar['field_by_the_numbers_number_3']['und'][0]['value'],
                'label'  => $dataPillar['field_by_the_numbers_label_3']['und'][0]['value']
            ),
            array(
                'number' => $dataPillar['field_by_the_numbers_number_4']['und'][0]['value'],
                'label'  => $dataPillar['field_by_the_numbers_label_4']['und'][0]['value']
            )
        ),
        'stories' => $storiesArr
    );

    # Display JSON
    echo json_encode( $arr ); ?>