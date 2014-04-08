<?php
/**
 * VideoEditorController class file.
 *
 * PHP Version 5.3
 *
 * @package  TopHat
 * @author   Shaun Persad <shaunpersad@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://shaunpersad.com
 */


namespace TopHat\Admin;

use TopHat\Controller;
use TopHat\Core;
use TopHat\Media;
use TopHat\MediaVideo;

class VideoEditorController extends Controller {

    public function indexAction() {

        $video_id = $this->request->param('id', false);

        if ($video_id){

            $this->response->header('Location', "/admin/video-editor/{$video_id}/edit");
            return false;
        }

        $this->render($this->view);
    }



    public function uploadAction() {

        $video_data = array();

        $name_only = uniqid('video_');
        $extension = '';

        if ($this->request->files()->exists('video')) {

            try {

                $extension = Core::extensionFromFilename($_FILES['video']['name']);
                $name_only = Core::slugify(str_replace('.'.$extension, '', $_FILES['video']['name']));

                //download video to temp

                if (in_array($extension, Media::$video_extensions)) {

                    $file_name = time().'_'.rand().'_'.$name_only.'.'.strtolower($extension);

                    $path = TEMP_DIR.$file_name;
                    $url = TEMP_URL.$file_name;

                    if (Core::uploadFile('video', $path)) {

                        Core::queueTemporaryFile($path);

                        $video_data['path'] = $path;
                        $video_data['url'] = $url;
                        $video_data['source'] = Media::SOURCE_FILE;
                    }
                } else {

                    Core::addAlert('File extension not supported.', Core::ALERT_TYPE_ERROR);
                }



            } catch (\Exception $e) {

                Core::addAlert($e->getMessage(), Core::ALERT_TYPE_EXCEPTION);
            }

        } elseif ($video_url = $this->request->paramsPost()->get('video_url', false)) {

            $extension = Core::extensionFromFilename($video_url);

            if (in_array($extension, Media::$video_extensions)) {

                $video_data['url'] = $video_url;
                $video_data['source'] = Media::SOURCE_URL;

            } else {
                Core::addAlert('File extension not supported.', Core::ALERT_TYPE_ERROR);
            }

        } elseif ($video_embed_code = $this->request->paramsPost()->get('video_embed_code', false)) {

            $video_data['embed_code'] = $video_embed_code;
            $video_data['source'] = Media::SOURCE_EMBED;
        }

        if (empty($video_data)) {

            $video_data['error'] = true;
        }

        $this->response->header('Location', '/admin/video-editor/edit?'.http_build_query($video_data));

    }

    public function editAction() {

        $video_id = $this->request->param('id', false);

        if ($video_id && $video = Core::getMedia($video_id)) {

            $this->vars->video = $video;
        } else {

            $this->vars->video_data = $this->request->paramsGet()->all();
        }


        $this->render($this->view);

    }

    public function saveAction() {

        $return_data = array();

        if ($video_data = $this->request->paramsPost()->all(array('id', 'title', 'source', 'url', 'embed_code'))) {

            $video_data['type'] = Media::TYPE_VIDEO;

            $video = new MediaVideo($video_data);

            if (!empty($video->source)) {

                if ($video->source == Media::SOURCE_FILE) {

                    if ($path = $this->request->paramsPost()->get('path', false)) {

                        $original_video = false;

                        if (!empty($video->id)) {

                            $original_video = Core::getMedia($video->id);
                        }

                        if (!$original_video || ($original_video->title != $video->title)) {

                            $extension = Core::extensionFromFilename($path);

                            $name_only = time().'_'.rand().'_'.Core::slugify($video->title);

                            $file_name = $name_only.'.'.strtolower($extension);

                            if (copy($path, UPLOADS_DIR.$file_name)) {

                                $video->url = UPLOADS_URL.$file_name;
                                $video->file_name = $file_name;
                                $video->extension = $extension;
                                $video->upload_dir = UPLOADS_DIR;

                                $video_id = $video->save();

                            }

                        }

                    }
                    if (!empty($video->id)) {

                        $return_data = array(
                            'id' => $video->id,
                            'url' => $video->url()
                        );
                    }


                } elseif ($video->source == Media::SOURCE_URL) {

                    $original_video = false;

                    if (!empty($video->id)) {

                        $original_video = Core::getMedia($video->id);
                    }

                    if (!$original_video || ($original_video->title != $video->title) || ($original_video->url != $video->url)) {

                        $extension = Core::extensionFromFilename($video->url);

                        $video->extension = $extension;

                        $video->save();

                    }

                    if (!empty($video->id)) {

                        $return_data = array(
                            'id' => $video->id,
                            'url' => $video->url()
                        );
                    }

                } elseif ($video->source == Media::SOURCE_EMBED) {

                    $original_video = false;

                    if (!empty($video->id)) {

                        $original_video = Core::getMedia($video->id);
                    }

                    if (!$original_video || ($original_video->title != $video->title) || ($original_video->embed_code != $video->embed_code)) {

                        $video->save();
                    }

                    if (!empty($video->id)) {

                        $return_data = array(
                            'id' => $video->id,
                            'embed_code' => $video->embed_code
                        );
                    }
                }
            }

        }

        if (!empty($return_data)) {

            Core::deleteTemporaryFiles();

            $this->response->json($return_data);
        }

    }

}
