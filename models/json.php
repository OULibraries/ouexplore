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
  $urlStories = 'https://exploredata.libraries.ou.edu/restep/stories?tid=' . $nidPillar;
  $jsonStories = curl_get_contents($urlStories);
  $dataStories = json_decode($jsonStories, TRUE);

  foreach ($dataStories as $story) {
      $urlSingleStory = $story['uri'];
      $multiImageArray = [];
      $description = !empty($story['description']) ? $story['description'] : '';

      array_push($storiesArr, [
        'id' => $story['vid'],
        'title' => $story['title'],
        'body' => $story['body'],
        'description' => $description,
        'image' => 'https://exploredata.libraries.ou.edu/sites/default/files/' . $story['image']['filename'],
        'multiImage' => $multiImageArray
      ]);
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