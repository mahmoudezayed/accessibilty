<?php

namespace Drupal\ac_ffmpeg;

/**
* Class VideoMerger.
*/
class VideoMerger {
  /**
   * .
   */
  private $php_ffmpeg;

  /**
   * Class constructor.
   */
  public function __construct($php_ffmpeg)
  {
    $this->php_ffmpeg = $php_ffmpeg;
  }

  /**
   * 
   */
  public function concateVideos($videos, $entity_id) {
    $files_path = \Drupal::service('file_system')
      ->realpath(file_default_scheme() . "://") . '/';
    $output_path = 'ffmpeg/output/video_' . date('Y-m-d-h-s-i') . '_' . $entity_id . '.mp4';

    $video = $this->php_ffmpeg->open($videos[0]);
    $video
      ->concat($videos)
      ->saveFromSameCodecs($files_path . $output_path, TRUE);
     
    return file_create_url('public://' . $output_path);
  }
  
}
