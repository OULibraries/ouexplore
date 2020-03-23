<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    function getPillars( $type ){
        stream_context_set_default(array(
            'ssl'                => array(
            'peer_name'          => 'generic-server',
            'verify_peer'        => FALSE,
            'verify_peer_name'   => FALSE,
            'allow_self_signed'  => TRUE
        )));
        
        $url  = 'https://exploredata.libraries.ou.edu/restep/taxonomy_term/';
        $json = curl_get_contents( $url );
        $data = json_decode( $json, TRUE);
        $data = array_reverse( $data );
        
        foreach( $data as $key => $value){
            if( $value['vid'] == 2){
                
                stream_context_set_default(array(
                    'ssl'                => array(
                    'peer_name'          => 'generic-server',
                    'verify_peer'        => FALSE,
                    'verify_peer_name'   => FALSE,
                    'allow_self_signed'  => TRUE
                )));
                
                $url  = 'https://exploredata.libraries.ou.edu/restep/taxonomy_term/'.$value['tid'];
                $json = curl_get_contents( $url );
                $data = json_decode( $json, TRUE);

                $imgURL = 'https://exploredata.libraries.ou.edu/sites/default/files/' . $data['field_pillar_image']['und'][0]['filename'];
                
                //  echo '<pre>';
                //  print_r($imgURL);
                //  echo '<pre>';
                
                if( $type == 'image' ){
                    $markup = (
                        '<div>'.
                            '<a href="#" data-action="openPillar" data-pillar-id="'.$data['tid'].'">'.
                                '<img src="'.$imgURL.'" alt="Pillar ' . $value['tid'] . ' "/>'.
                            '</a>'.
                        '</div>'
                    );
                    echo $markup;
                }
                if( $type == 'list' ){
                    $markup = (
                        '<div>'.
                            '<div class="accents left">'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                            '</div>'.
                            '<h2>'.
                                '<a href="#" data-action="openPillar" data-pillar-id="'.$data['tid'].'">'.$data['name'].'</a>'.
                            '</h2>'.
                            '<div class="accents right">'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                                '<span></span>'.
                            '</div>'.
                        '</div>'
                    );
                    echo $markup;
                }
                
            }
        }
    }

    function getIssues(){
        stream_context_set_default(array(
            'ssl'                => array(
            'peer_name'          => 'generic-server',
            'verify_peer'        => FALSE,
            'verify_peer_name'   => FALSE,
            'allow_self_signed'  => TRUE
        )));
        
        $url  = 'https://exploredata.libraries.ou.edu/restep/taxonomy_term/';
        $json = curl_get_contents( $url );
        $data = json_decode( $json, TRUE);
        $data = array_reverse( $data );
        
        foreach( $data as $key => $value){
            if( $value['vid'] == 3){
                
                stream_context_set_default(array(
                    'ssl'                => array(
                    'peer_name'          => 'generic-server',
                    'verify_peer'        => FALSE,
                    'verify_peer_name'   => FALSE,
                    'allow_self_signed'  => TRUE
                )));
                
                $url  = 'https://exploredata.libraries.ou.edu/restep/taxonomy_term/'.$value['tid'];
                $json = curl_get_contents( $url );
                $data = json_decode( $json, TRUE);

                $markup = (
                    '<div class="issueItem">'.
                        '<div class="img" style="background: url(https://exploredata.libraries.ou.edu/sites/default/files/'.$data['field_issue_image']['und'][0]['filename'].') no-repeat center center / cover;"></div>'.
                        '<div><h2><a href="#">'.$data['name'].'</a></h2><div class="description">'.$data['description'].'</div></div>'.
                    '</div>'
                );

                echo $markup;

                
            }
        }
    }

function curl_get_contents($url) {
    // Initiate the curl session
    $ch = curl_init();
    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);
    // Removes the headers from the output
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // Return the output instead of displaying it directly
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    // Execute the curl session
    $output = curl_exec($ch);
    header('Content-type: application/json');
//    error_log('blah blah: ' . $output);
    // Close the curl session
    curl_close($ch);
    // Return the output as a variable
    return $output;
}