<?php
namespace Drupal\ac_ffmpeg\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides route responses for the Example module.
 */
class TestController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function testPage() {
    $files_path = \Drupal::service('file_system')
      ->realpath(file_default_scheme() . "://") . '/';

    $videos = [
      $files_path . 'ffmpeg/test/1.mp4',
      $files_path . 'ffmpeg/test/2.mp4',
      $files_path . 'ffmpeg/test/3.mp4',
      $files_path . 'ffmpeg/test/4.mp4',
      
    ];

    $concated_videos = $this->concateVideos($videos);

    return [
      '#theme' => 'html5_ffmpeg',
      '#video_url' => $concated_videos,
    ];
  }

  public function concateVideos($videos) {
    
    $files_path = \Drupal::service('file_system')
      ->realpath(file_default_scheme() . "://") . '/';

    $ffmpeg = \Drupal::service('php_ffmpeg');
    $video = $ffmpeg->open($videos[0]);
    $video
      ->concat($videos)
      ->saveFromSameCodecs($files_path . 'ffmpeg/output.mp4', TRUE);

    return 'sites/default/files/ffmpeg/output.mp4';
  }

}
