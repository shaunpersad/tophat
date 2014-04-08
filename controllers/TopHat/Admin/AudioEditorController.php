<?php
/**
 * AudioEditorController class file.
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
use TopHat\MediaAudio;

class AudioEditorController extends Controller {

    public function indexAction() {

        $audio_id = $this->request->param('id', false);

        if ($audio_id){

            $this->response->header('Location', "/admin/audio-editor/{$audio_id}/edit");
            return false;
        }

        $this->render($this->view);
    }



    public function uploadAction() {

        $audio_data = array();

        $name_only = uniqid('audio_');
        $extension = '';

        if ($this->request->files()->exists('audio')) {

            try {

                $extension = Core::extensionFromFilename($_FILES['audio']['name']);
                $name_only = Core::slugify(str_replace('.'.$extension, '', $_FILES['audio']['name']));

                //download audio to temp

                if (in_array($extension, Media::$audio_extensions)) {

                    $file_name = time().'_'.rand().'_'.$name_only.'.'.strtolower($extension);

                    $path = TEMP_DIR.$file_name;
                    $url = TEMP_URL.$file_name;

                    if (Core::uploadFile('audio', $path)) {

                        Core::queueTemporaryFile($path);

                        $audio_data['path'] = $path;
                        $audio_data['url'] = $url;
                        $audio_data['source'] = Media::SOURCE_FILE;
                    }
                } else {

                    Core::addAlert('File extension not supported.', Core::ALERT_TYPE_ERROR);
                }



            } catch (\Exception $e) {

                Core::addAlert($e->getMessage(), Core::ALERT_TYPE_EXCEPTION);
            }

        } elseif ($audio_url = $this->request->paramsPost()->get('audio_url', false)) {

            $extension = Core::extensionFromFilename($audio_url);

            if (in_array($extension, Media::$audio_extensions)) {

                $audio_data['url'] = $audio_url;
                $audio_data['source'] = Media::SOURCE_URL;

            } else {
                Core::addAlert('File extension not supported.', Core::ALERT_TYPE_ERROR);
            }

        } elseif ($audio_embed_code = $this->request->paramsPost()->get('audio_embed_code', false)) {

            $audio_data['embed_code'] = $audio_embed_code;
            $audio_data['source'] = Media::SOURCE_EMBED;
        }

        if (empty($audio_data)) {

            $audio_data['error'] = true;
        }

        $this->response->header('Location', '/admin/audio-editor/edit?'.http_build_query($audio_data));

    }

    public function editAction() {

        $audio_id = $this->request->param('id', false);

        if ($audio_id && $audio = Core::getMedia($audio_id)) {

            $this->vars->audio = $audio;
        } else {

            $this->vars->audio_data = $this->request->paramsGet()->all();
        }


        $this->render($this->view);

    }

    public function saveAction() {

        $return_data = array();

        if ($audio_data = $this->request->paramsPost()->all(array('id', 'title', 'source', 'url', 'embed_code'))) {

            $audio_data['type'] = Media::TYPE_AUDIO;

            $audio = new MediaAudio($audio_data);

            if (!empty($audio->source)) {

                if ($audio->source == Media::SOURCE_FILE) {

                    if ($path = $this->request->paramsPost()->get('path', false)) {

                        $original_audio = false;

                        if (!empty($audio->id)) {

                            $original_audio = Core::getMedia($audio->id);
                        }

                        if (!$original_audio || ($original_audio->title != $audio->title)) {

                            $extension = Core::extensionFromFilename($path);

                            $name_only = time().'_'.rand().'_'.Core::slugify($audio->title);

                            $file_name = $name_only.'.'.strtolower($extension);

                            if (copy($path, UPLOADS_DIR.$file_name)) {

                                $audio->url = UPLOADS_URL.$file_name;
                                $audio->file_name = $file_name;
                                $audio->extension = $extension;
                                $audio->upload_dir = UPLOADS_DIR;

                                $audio_id = $audio->save();

                            }

                        }

                    }
                    if (!empty($audio->id)) {

                        $return_data = array(
                            'id' => $audio->id,
                            'url' => $audio->url()
                        );
                    }


                } elseif ($audio->source == Media::SOURCE_URL) {

                    $original_audio = false;

                    if (!empty($audio->id)) {

                        $original_audio = Core::getMedia($audio->id);
                    }

                    if (!$original_audio || ($original_audio->title != $audio->title) || ($original_audio->url != $audio->url)) {

                        $extension = Core::extensionFromFilename($audio->url);

                        $audio->extension = $extension;

                        $audio->save();

                    }

                    if (!empty($audio->id)) {

                        $return_data = array(
                            'id' => $audio->id,
                            'url' => $audio->url()
                        );
                    }

                } elseif ($audio->source == Media::SOURCE_EMBED) {

                    $original_audio = false;

                    if (!empty($audio->id)) {

                        $original_audio = Core::getMedia($audio->id);
                    }

                    if (!$original_audio || ($original_audio->title != $audio->title) || ($original_audio->embed_code != $audio->embed_code)) {

                        $audio->save();
                    }

                    if (!empty($audio->id)) {

                        $return_data = array(
                            'id' => $audio->id,
                            'embed_code' => $audio->embed_code
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
