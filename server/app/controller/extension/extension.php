<?php
require_once DIR_SYSTEM.'library/engine/controller.php';

class ExtensionController extends Controller {

    public function index() {

        // Get post data from client
        $_POST = json_decode(file_get_contents('php://input'), true);

        // Determine what the client needs
        if ($_POST['type'] == 'getAllExtensions') {
            $this->getAllExtensions($_POST);
        } elseif ($_POST['type'] == 'getExtension') {
            $this->getExtension($_POST);
        } elseif ($_POST['type'] == 'getInfoForAddExtension') {
            $this->getInfoForAddExtension();
        } elseif ($_POST['type'] == 'editExtension') {
            $this->editExtension($_POST);
        } elseif ($_POST['type'] == 'deleteExtension') {
            $this->deleteExtension($_POST);
        } else {
            echo json_encode(['error' => 'No such type of request']);
        }

    }

    // Request type = getAllExtensions
    public function getAllExtensions($post) {

        // Get page
        $page = $post['page'];

        // Load model
        $this->registry->get('load')->model('extension/reception');
        $this->registry->get('load')->model('extension/extension');

        // Get string from site
        $string = $this->registry->get('model_extension_reception')->getExtensions($page);

        // Get html from string
        $dom = $this->registry->get('htmlParser')->getDomHtml($string);

        // Get extensions data
        $extensions_data = $this->registry->get('model_extension_extension')->getExtensionsData($dom);

        // If client need pagination and it is just first request we get pagination
        if (!$_POST['pagination']) {
            $pagination = $this->getPagination();
        } else {
            $pagination = $_POST['pagination'];
        }

        // Form and send the answer
        $data = ['count' => $pagination, 'extensions' => $extensions_data];

        echo json_encode($data);

    }

    // Request type = getExtension
    public function getExtension($post) {

        // Get id from client
        $id = $post['id'];

        // Load models
        $this->registry->get('load')->model('extension/reception');
        $this->registry->get('load')->model('extension/extension');

        // Get string from site
        $string = $this->registry->get('model_extension_reception')->getExtension($id);

        // Get html from string
        $dom = $this->registry->get('htmlParser')->getDomHtml($string);

        // Get all extension data and send it
        $data = $this->registry->get('model_extension_extension')->parseExtensionData($dom);

        echo json_encode($data);
    }

    // Request type = editExtension
    public function editExtension($post) {

        // Get id and data from client
        $id = $post['id'];
        $data = $post['data'];

        // Load models
        $this->registry->get('load')->model('extension/reception');
        $this->registry->get('load')->model('extension/extension');

        // Get string from site
        $string = $this->registry->get('model_extension_reception')->getExtension($id);

        // Get html from string
        $dom = $this->registry->get('htmlParser')->getDomHtml($string);

        // Get all extension data and send it
        $old_data = $this->registry->get('model_extension_extension')->parseForEditExtension($dom);

        if ($data['publish'] === false) {
            $data['publish'] = '0';
        } else {
            $data['publish'] = '1';
        }

        if ($data['alert'] === false) {
            $data['alert'] = '0';
        } else {
            $data['alert'] = '1';
        }

        if ($data['notify'] === false) {
            $data['notify'] = '0';
        } else {
            $data['notify'] = '1';
        }

        //var_dump($data['category']);exit;
        foreach ($old_data['extension_category_list'] as $key => $item) {
            if ($item === $data['category']) {
                $data['category'] = (string)$key;
                break;
            }
        };

        if ($data['license'] === 'Free') {
            $data['license'] = '0';
        } else {
            $data['license'] = '1';
        }


        foreach ($old_data['license_period_list'] as $key => $item) {
            if ($item === $data['license_period']) {
                $data['license_period'] = $key;
                break;
            }
        }

        $compatibility_mas = array();
        foreach ($data['compatibility'] as $compatibility) {
            foreach ($old_data['compatibility_list'] as $key => $item) {
                if ($compatibility === $item) {
                    $compatibility_mas[] = ''.$key.'';
                }
            }
        }

        $data = array(
            "name"=>  $data['name'],
            "price"=> $data['price'],
            "image"=> "5c6574564efe8.jpg",
            "banner"=> "5c65745e486f2.jpg",
            "extension_image[0][image]"=>  "5c6573de08e70.jpg",
            "extension_download[0][name]"=>  $old_data['extension_download[0][name]'],
            "extension_download[0][extension_download_id]"=> $old_data['extension_download[0][extension_download_id]'],
            "extension_download[0][filename]"=> $old_data['extension_download[0][filename]'],
            "extension_download[0][mask]"=> $old_data["extension_download[0][mask]"],
            "newsletter"=> "",
            "extension_download[0][download]" => $compatibility_mas,
            "publish" =>  $data['publish'],
            "notify" =>  $data['notify'],
            "alert" =>  $data['alert'],
            "description"=>  $data['description'],
            "tag"=>  $data['tag'],
            "documentation"=>  $data['documentation'],
            "extension_category_id"=> $data['category'],
            "license"=>  $data['license'],
            "license_period" => $data['license_period'],
        );

        $this->registry->get('model_extension_reception')->editExtension($id, $data);

        $this->getExtension($post);
    }

    // Request type = deleteExtension
    public function deleteExtension($post) {

        // Get id from client
        $id = $post['id'];

        // Load model
        $this->registry->get('load')->model('extension/reception');

        $data = $this->registry->get('model_extension_reception')->deleteExtension($id);

        echo json_encode($data);
    }

    public function getInfoForAddExtension() {

        // Load model
        $this->registry->get('load')->model('extension/reception');
        $this->registry->get('load')->model('extension/extension');

        // Get string from site
        $string = $this->registry->get('model_extension_reception')->getExtensions();

        // Get html from string
        $dom = $this->registry->get('htmlParser')->getDomHtml($string);

        // Get id
        $id = $this->registry->get('model_extension_extension')->getRandomId($dom);

        // Get string from site
        $string = $this->registry->get('model_extension_reception')->getExtension($id);

        // Get html from string
        $dom = $this->registry->get('htmlParser')->getDomHtml($string);

        $data = $this->registry->get('model_extension_extension')->getInfoForAdd($dom);

        echo json_encode($data);

    }


    public function getPagination() {

        // Load model
        $this->registry->get('load')->model('extension/reception');
        $this->registry->get('load')->model('extension/extension');

        // Get string from site
        $string = $this->registry->get('model_extension_reception')->getExtensions();

        // Get html from string
        $dom = $this->registry->get('htmlParser')->getDomHtml($string);

        // Count pagination pages
        $pages = $this->registry->get('model_extension_extension')->countPagination($dom);

        return $pages;

    }

}