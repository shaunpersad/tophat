<?php
/**
 * ImageEditorController class file.
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
use WideImage\WideImage;

class ImageEditorController extends Controller {

    public function indexAction() {

        $image_id = $this->request->param('id', false);

        if ($image_id){

            $this->response->header('Location', "/admin/image-editor/{$image_id}/edit");
            return false;
        }

        $this->render($this->view);
    }



    public function uploadAction() {

        $name_only = uniqid('image_');
        $extension = 'png';

        if ($this->request->files()->exists('image')) {

            try {
                $img = WideImage::loadFromUpload('image');

                if ($img) {

                    $extension = Core::extensionFromFilename($_FILES['image']['name']);
                    $name_only = Core::slugify(str_replace('.'.$extension, '', $_FILES['image']['name']));
                }

            } catch (\WideImage\Exception\Exception $e) {

                Core::addAlert($e->getMessage(), Core::ALERT_TYPE_EXCEPTION);
            }



        } elseif ($image_url = $this->request->paramsPost()->get('image_url', false)) {

            try {

                $img = WideImage::load($image_url);

                if ($img) {

                    $extension = Core::extensionFromFilename($image_url);
                }

            } catch (\WideImage\Exception\Exception $e) {

                Core::addAlert($e->getMessage(), Core::ALERT_TYPE_EXCEPTION);
            }
        }

        if (!in_array($extension, Media::$image_extensions)) {

            $extension = 'png';
        }

        if (empty($img)) {

            Core::addAlert('Error uploading image.', Core::ALERT_TYPE_ERROR);
            return false;
        }

        $file_name = time().'_'.rand().'_'.$name_only.'.'.strtolower($extension);

        $img->saveToFile(TEMP_DIR.$file_name);

        Core::queueTemporaryFile(TEMP_DIR.$file_name);

        $orientation = 'horizontal';

        if ($img->getHeight() > $img->getWidth()) {

            $orientation = 'vertical';
        }


        $image_data = array(
            'path' => TEMP_DIR.$file_name,
            'url' => TEMP_URL.$file_name,
            'orientation' => $orientation
        );

        $this->response->header('Location', '/admin/image-editor/edit?'.http_build_query($image_data));

    }

    public function editAction() {

        $image_id = $this->request->param('id', false);

        if ($image_id && $image = Core::getMedia($image_id)) {

            $this->vars->image = $image;
        } else {

            $this->vars->image_data = $this->request->paramsGet()->all();

        }


        $this->render($this->view);

    }

    public function saveAction() {

        if ($this->request->paramsPost()->exists('image_data')) {

            $image_data = json_decode($this->request->paramsPost()->get('image_data'), true);


            if (!empty($image_data['title']) && !empty($image_data['path'])) {

                $path = $image_data['path'];

                $ratios = array();

                if (!empty($image_data['ratios']) && is_array($image_data['ratios'])) {

                    $ratios = $image_data['ratios'];
                }

                $original_image = false;
                if (!empty($image_data['id'])) {

                    $original_image = Core::getMedia($image_data['id']);
                }

                $file_name = '';
                $extension = '';
                $name_only = '';

                if ($original_image) {

                    if ($original_image->title == $image_data['title']) {

                        $file_name = $original_image->file_name;
                        $extension = $original_image->extension;
                        $name_only = str_replace('.'.$extension, '', $file_name);
                    }
                }
                if (empty($file_name)) {

                    $exp1 = explode(DIRECTORY_SEPARATOR, $path);
                    $file_name = $exp1[count($exp1) -1];

                    $exp2 = explode('.', $file_name);
                    $extension = $exp2[count($exp2) - 1];

                    $name_only = time().'_'.rand().'_'.Core::slugify($image_data['title']);;

                    $file_name = $name_only.'.'.strtolower($extension);

                }

                $img = WideImage::loadFromFile($path);

                $img->saveToFile(UPLOADS_DIR.$file_name);




                $media_data = array(
                    'title' => $image_data['title'],
                    'description' => '',
                    'type' => Media::TYPE_IMAGE,
                    'source' => Media::SOURCE_FILE,
                    'file_name' => $file_name,
                    'extension' => $extension,
                    'upload_dir' => UPLOADS_DIR,
                    'url' => UPLOADS_URL.$file_name
                );

                if (!empty($image_data['id'])) {

                    $media_data['id'] = $image_data['id'];
                }

                $media = Media::createFromData($media_data);

                $normalizing_width = 500;

                if ($image_id = $media->save()) {

                    $orientation = 'horizontal';

                    if ($img->getHeight() > $img->getWidth()) {

                        $orientation = 'vertical';
                        $factor = $img->getHeight() / $normalizing_width;
                    } else {
                        $factor = $img->getWidth() / $normalizing_width;
                    }

                    foreach ($ratios as $ratio) {

                        $x1 = $ratio['x1'] * $factor;
                        $y1 = $ratio['y1'] * $factor;
                        $width = $ratio['width'] * $factor;
                        $height = $ratio['height'] * $factor;



                        if ($media->saveRatioData(
                            $ratio['breadth'],
                            $ratio['length'],
                            $ratio['x1'],
                            $ratio['y1'],
                            $ratio['x2'],
                            $ratio['y2'],
                            $ratio['width'],
                            $ratio['height'],
                            $normalizing_width
                        )) {

                            $cropped = $img->crop($x1, $y1, $width, $height);
                            $cropped_file_name = $name_only.'_ratio_'.$ratio['breadth'].'_'.$ratio['length'].'.'.$extension;
                            $cropped->saveToFile(UPLOADS_DIR.$cropped_file_name);
                        }

                    }

                    Core::deleteTemporaryFiles();

                    $image_data = array(
                        'id' => $image_id,
                        'url' => $media_data['url'],
                        'orientation' => $orientation
                    );

                    $this->response->json($image_data);
                }
            }


        }




    }

}
 