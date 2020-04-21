<?php
    function getPillars() {
        $markup_image = '';
        $markup = '';
        $html_code = '<div class="pillars">';

        stream_context_set_default(array(
          'ssl'                => array(
          'peer_name'          => 'generic-server',
          'verify_peer'        => FALSE,
          'verify_peer_name'   => FALSE,
          'allow_self_signed'  => TRUE
        )));

        $url  = 'https://exploredata.libraries.ou.edu/restep/pillars?type=pillars';
        $json = curl_get_contents( $url );
        $data = json_decode( $json, TRUE);

        foreach($data as $key => $value) {
            $markup_image .=
                '<div>'.
                    '<a href="#" data-action="openPillar" data-pillar-id="'.$value['tid'].'">'.
                        '<img src="'.$value['field_pillar_image_url'].'" alt="Pillar ' . $value['tid'] . ' "/>'.
                    '</a>'.
                '</div>';

            $markup .=
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
                        '<a href="#" data-action="openPillar" data-pillar-id="'.$value['tid'].'">'.htmlspecialchars_decode($value['name']).'</a>'.
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
                '</div>';
        }

        $html_code .= $markup_image;
        $html_code .= '</div><div class="pillarTitles"><div>';
        $html_code .= $markup;
        $html_code .= '</div></div><div class="markers"><div></div><div></div><div></div><div></div><div></div></div></div>';
        echo $html_code;
    }

    function getIssues() {
        stream_context_set_default(array(
          'ssl'                => array(
            'peer_name'          => 'generic-server',
            'verify_peer'        => FALSE,
            'verify_peer_name'   => FALSE,
            'allow_self_signed'  => TRUE
        )));

        $url  = 'https://exploredata.libraries.ou.edu/restep/pillars?type=issue';
        $json = curl_get_contents($url);
        $data = json_decode( $json, TRUE);

        foreach($data as $key => $value) {
            $markup = (
                '<div class="issueItem">'.
                    '<div class="img" style="background: url('.$value['field_issue_image_url'].') no-repeat center center / cover;"></div>'.
                    '<div><h2><a>'.$value['name'].'</a></h2><div class="description">'.$value['description'].'</div></div>'.
                '</div>'
            );
            echo $markup;
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
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
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