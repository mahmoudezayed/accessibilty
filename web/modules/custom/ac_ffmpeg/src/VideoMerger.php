<?php

namespace Drupal\ac_ffmpeg;

/**
* Class VideoMerger.
*/
class VideoMerger {
  
  /**
   * The FFMpeg service.
   *
   * @var \FFMpeg\FFMpeg
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
   * Concate some videos.
   * 
   * @param array $videos
   *  The array of videos that we need to concate.
   * @param integer $entity_id
   *  The id of entity that we will save the concated video to it.
   * 
   * @return string
   *   File Url.
   */
  public function concateVideos($videos, $entity_id) {
    $files_path = \Drupal::service('file_system')
      ->realpath(file_default_scheme() . "://") . '/';
    $output_path = 'ffmpeg/output/video_' . date('Y-m-d-h-s-i') . '_' . $entity_id . '.mp4';
    $ffmpeg = $this->php_ffmpeg;
    $video = $ffmpeg->open($videos[0]);
    $video
      ->concat($videos)
      ->saveFromSameCodecs($files_path . $output_path, TRUE);
     
    return file_create_url('public://' . $output_path);
  }
  
}
