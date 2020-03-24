<?php
  header('Content-Type: application/json');
  stream_context_set_default([
    'ssl' => [
      'peer_name' => 'generic-server',
      'verify_peer' => FALSE,
      'verify_peer_name' => FALSE,
      'allow_self_signed' => TRUE,
    ],
  ]);

  include str_replace('/models', '', __DIR__) . '/functions.php';

  # Get Pillar Details
  $nidPillar = $_GET['nid'];
  $urlPillar = 'https://exploredata.libraries.ou.edu/restep/taxonomy_term/' . $nidPillar;
  $jsonPillar = curl_get_contents($urlPillar);
  $dataPillar = json_decode($jsonPillar, TRUE);
  $storiesArr = [];
  $i = 0;
  $j = 1;
  $k = 0;
  $urlStories = 'https://exploredata.libraries.ou.edu/restep/node?page=' . $i . '&pagesize=200';

  while ($j < 2 & $k < 3) {
    # Get Associated Stories
    $jsonStories = curl_get_contents($urlStories);
    $dataStories = json_decode($jsonStories, TRUE);
    if (array_key_exists(0, $dataStories)) {
      $i++;
    } else {
      $j++;
      break;
    }

    foreach ($dataStories as $story) {
      $urlSingleStory = $story['uri'];
      $jsonSingleStory = curl_get_contents($urlSingleStory);
      $exists = strpos($jsonSingleStory, 'tid":"' . $nidPillar);

      if (!$exists) {
        continue;
      }

      $dataSingleStory = json_decode($jsonSingleStory, TRUE);
      if (!array_key_exists('und', $dataSingleStory['field_pillars'])) {
        continue;
      }

      $multiImageArray = [];
      $description = '';
      if ($dataSingleStory['field_pillars']['und'][0]['tid'] == $nidPillar) {
        $k++;
        # Push story to stories array
        # Uncomment if you want to start using multiple images
        //            if ($dataSingleStory['field_more_images']) {
        //                foreach ($dataSingleStory['field_more_images']['und'] as $multiImage) {
        //                    array_push($multiImageArray, 'https://exploredata.libraries.ou.edu/sites/default/files/' . $multiImage['filename']);
        //                }
        //            }
        if (array_key_exists('und', $dataSingleStory['field_description'])) {
          $description = $dataSingleStory['field_description']['und'][0]['value'];
        }

        array_push($storiesArr, [
            'id' => $dataSingleStory['vid'],
            'title' => $dataSingleStory['title'],
            'body' => $dataSingleStory['body']['und'][0]['value'],
            'description' => $description,
            'image' => 'https://exploredata.libraries.ou.edu/sites/default/files/' . $dataSingleStory['field_cover_image']['und'][0]['filename'],
            'multiImage' => $multiImageArray,
          ]);
      }

      if ($k == 3) {
        break;
      }
    }
    $urlStories = 'https://exploredata.libraries.ou.edu/restep/node?page=' . $i;
  }
  # Create array of Pillar information.
  $arr = [
    'title' => $dataPillar['name'],
    'description' => str_replace([
      "\n",
      "\r",
      "\t",
    ], '', $dataPillar['description']),
    'image' => 'https://exploredata.libraries.ou.edu/sites/default/files/' . $dataPillar['field_pillar_image']['und'][0]['filename'],
    'stats' => [
      [
        'number' => $dataPillar['field_by_the_numbers_number_1']['und'][0]['value'],
        'label' => $dataPillar['field_by_the_numbers_label_1']['und'][0]['value'],
      ],
      [
        'number' => $dataPillar['field_by_the_numbers_number_2']['und'][0]['value'],
        'label' => $dataPillar['field_by_the_numbers_label_2']['und'][0]['value'],
      ],
      [
        'number' => $dataPillar['field_by_the_numbers_number_3']['und'][0]['value'],
        'label' => $dataPillar['field_by_the_numbers_label_3']['und'][0]['value'],
      ],
      [
        'number' => $dataPillar['field_by_the_numbers_number_4']['und'][0]['value'],
        'label' => $dataPillar['field_by_the_numbers_label_4']['und'][0]['value'],
      ],
    ],
    'stories' => $storiesArr,
  ];
  # Display JSON
  echo json_encode($arr);