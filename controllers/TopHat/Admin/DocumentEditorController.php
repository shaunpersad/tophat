<?php
/**
 * DocumentEditorController class file.
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
use TopHat\MediaDocument;

class DocumentEditorController extends Controller {

    public function indexAction() {

        $document_id = $this->request->param('id', false);

        if ($document_id){

            $this->response->header('Location', "/admin/document-editor/{$document_id}/edit");
            return false;
        }

        $this->render($this->view);
    }



    public function uploadAction() {

        $document_data = array();

        $name_only = uniqid('document_');
        $extension = '';

        if ($this->request->files()->exists('document')) {

            try {

                $extension = Core::extensionFromFilename($_FILES['document']['name']);
                $name_only = Core::slugify(str_replace('.'.$extension, '', $_FILES['document']['name']));

                //download document to temp

                if (in_array($extension, Media::$document_extensions)) {

                    $file_name = time().'_'.rand().'_'.$name_only.'.'.strtolower($extension);

                    $path = TEMP_DIR.$file_name;
                    $url = TEMP_URL.$file_name;

                    if (Core::uploadFile('document', $path)) {

                        Core::queueTemporaryFile($path);

                        $document_data['path'] = $path;
                        $document_data['url'] = $url;
                        $document_data['source'] = Media::SOURCE_FILE;
                    }
                } else {

                    Core::addAlert('File extension not supported.', Core::ALERT_TYPE_ERROR);
                }



            } catch (\Exception $e) {

                Core::addAlert($e->getMessage(), Core::ALERT_TYPE_EXCEPTION);
            }

        } elseif ($document_url = $this->request->paramsPost()->get('document_url', false)) {

            $extension = Core::extensionFromFilename($document_url);

            if (in_array($extension, Media::$document_extensions)) {

                $document_data['url'] = $document_url;
                $document_data['source'] = Media::SOURCE_URL;

            } else {
                Core::addAlert('File extension not supported.', Core::ALERT_TYPE_ERROR);
            }

        } elseif ($document_embed_code = $this->request->paramsPost()->get('document_embed_code', false)) {

            $document_data['embed_code'] = $document_embed_code;
            $document_data['source'] = Media::SOURCE_EMBED;
        }

        if (empty($document_data)) {

            $document_data['error'] = true;
        }

        $this->response->header('Location', '/admin/document-editor/edit?'.http_build_query($document_data));

    }

    public function editAction() {

        $document_id = $this->request->param('id', false);

        if ($document_id && $document = Core::getMedia($document_id)) {

            $this->vars->document = $document;
        } else {

            $this->vars->document_data = $this->request->paramsGet()->all();
        }


        $this->render($this->view);

    }

    public function saveAction() {

        $return_data = array();

        if ($document_data = $this->request->paramsPost()->all(array('id', 'title', 'source', 'url', 'embed_code'))) {

            $document_data['type'] = Media::TYPE_DOCUMENT;

            $document = new MediaDocument($document_data);

            if (!empty($document->source)) {

                if ($document->source == Media::SOURCE_FILE) {

                    if ($path = $this->request->paramsPost()->get('path', false)) {

                        $original_document = false;

                        if (!empty($document->id)) {

                            $original_document = Core::getMedia($document->id);
                        }

                        if (!$original_document || ($original_document->title != $document->title)) {

                            $extension = Core::extensionFromFilename($path);

                            $name_only = time().'_'.rand().'_'.Core::slugify($document->title);

                            $file_name = $name_only.'.'.strtolower($extension);

                            if (copy($path, UPLOADS_DIR.$file_name)) {

                                $document->url = UPLOADS_URL.$file_name;
                                $document->file_name = $file_name;
                                $document->extension = $extension;
                                $document->upload_dir = UPLOADS_DIR;

                                $document_id = $document->save();

                            }

                        }

                    }
                    if (!empty($document->id)) {

                        $return_data = array(
                            'id' => $document->id,
                            'url' => $document->url()
                        );
                    }


                } elseif ($document->source == Media::SOURCE_URL) {

                    $original_document = false;

                    if (!empty($document->id)) {

                        $original_document = Core::getMedia($document->id);
                    }

                    if (!$original_document || ($original_document->title != $document->title) || ($original_document->url != $document->url)) {

                        $extension = Core::extensionFromFilename($document->url);

                        $document->extension = $extension;

                        $document->save();

                    }

                    if (!empty($document->id)) {

                        $return_data = array(
                            'id' => $document->id,
                            'url' => $document->url()
                        );
                    }

                } elseif ($document->source == Media::SOURCE_EMBED) {

                    $original_document = false;

                    if (!empty($document->id)) {

                        $original_document = Core::getMedia($document->id);
                    }

                    if (!$original_document || ($original_document->title != $document->title) || ($original_document->embed_code != $document->embed_code)) {

                        $document->save();
                    }

                    if (!empty($document->id)) {

                        $return_data = array(
                            'id' => $document->id,
                            'embed_code' => $document->embed_code
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
