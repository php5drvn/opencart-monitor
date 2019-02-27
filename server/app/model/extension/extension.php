<?php

require_once DIR_SYSTEM.'library/engine/model.php';

class Extension extends Model {

    // Get general data of extensions
    public function getExtensionsData($dom) {
        $mas = array();

        // Find table with id 'extension-list'
        $table = $dom->find('table#extension-list');

        // Get child tag <tbody>
        $tbody = $table[0]->children[1];

        // Get mas with extensions
        foreach ($tbody->children as $tr) {
            $name = $tr->children[0]->plaintext;
            $status = trim($tr->children[1]->children[0]->plaintext);
            $date = $tr->children[2]->plaintext;
            $link = $tr->children[3]->children[0]->href;

            $extension_id = $this->getExtensionId($link);

            $mas[$extension_id] = ['name' => $name, 'status' => $status, 'date' => $date];
        }

        return $mas;
    }

    // Get extension id from link
    public function getExtensionId($link) {
        $link_parts = explode('&', $link);
        $extension_id = array_pop($link_parts);

        $search = strpos($extension_id, 'page');
        if ($search) {
            $extension_id = array_pop($link_parts);
        }

        $extension_id = explode('=', $extension_id);
        return array_pop($extension_id);
    }

    // Get one extension data from edit page of site
    public function parseExtensionData($dom) {

        $data = array();

        foreach ($dom->find('input') as $input){
            if($input->type == '' || $input->type == 'text' || $input->type == 'hidden'){
                $data[$input->name] = str_replace("&amp;","&",$input->value);
            }
        }

        foreach ($dom->find('input[checked]') as $input){


            if (strpos($input->name, '[]') !== false) {
                $input->name = str_replace('[]', '', $input->name);
                if(!isset($data[$input->name])){
                    $data[$input->name] = array();
                }
                $data[$input->name][] = $input->value;
            }else{
                $data[$input->name] = $input->value;
            }


        }

        foreach ($dom->find('textarea') as $input){
            $data[$input->name] = str_replace("&amp;","&",$input->innertext);
        }

        foreach ($dom->find('select') as $input){
            if(isset($input->find('option[selected]', 0)->value)){
                $data[$input->name] = $input->find('option[selected]', 0)->value;
            }else{
                $data[$input->name] = '';
            }
        }

        // Get notify, publish and alert
        $data = $this->getAlertPublishNotify($dom, $data);

        // Get image
        $data['image'] = $this->getImage($dom);

        // Get banner
        $data['banner'] = $this->getBanner($dom);

        // Get compatibility
        $compatibility = $this->getCompatibility($dom, $data);
        $data['compatibility'] = $compatibility['compatibility'];
        $data['compatibility_list'] = $compatibility['list'];

        // Get category
        $category = $this->getCategory($dom, $data);
        $data['extension_category'] = $category['category'];
        $data['extension_category_list'] = $category['list'];

        // Get License
        $data['license'] = $this->getLicense($dom, $data);

        // Get License Period
        $license_period = $this->getLicensePeriod($dom, $data);
        $data['license_period'] = $license_period['license_period'];
        $data['license_period_list'] = $license_period['list'];

        unset($data['extension_image[0][image]']);
        unset($data['extension_download[0][download]']);
        unset($data['extension_category_id']);
        unset($data['history']);
        unset($data['extension_download[0][extension_download_id]']);
        unset($data['extension_download[0][filename]']);
        unset($data['newsletter']);

        return $data;
    }

    // Get data for edit extension
    public function parseForEditExtension($dom) {
        $data = array();

        foreach ($dom->find('input') as $input){
            if($input->type == '' || $input->type == 'text' || $input->type == 'hidden'){
                $data[$input->name] = str_replace("&amp;","&",$input->value);
            }
        }

        foreach ($dom->find('input[checked]') as $input){


            if (strpos($input->name, '[]') !== false) {
                $input->name = str_replace('[]', '', $input->name);
                if(!isset($data[$input->name])){
                    $data[$input->name] = array();
                }
                $data[$input->name][] = $input->value;
            }else{
                $data[$input->name] = $input->value;
            }


        }

        foreach ($dom->find('textarea') as $input){
            $data[$input->name] = str_replace("&amp;","&",$input->innertext);
        }

        foreach ($dom->find('select') as $input){
            if(isset($input->find('option[selected]', 0)->value)){
                $data[$input->name] = $input->find('option[selected]', 0)->value;
            }else{
                $data[$input->name] = '';
            }
        }

        // Get compatibility
        $compatibility = $this->getCompatibility($dom, $data);
        $data['compatibility'] = $compatibility['compatibility'];
        $data['compatibility_list'] = $compatibility['list'];

        // Get category
        $category = $this->getCategory($dom, $data);
        $data['extension_category'] = $category['category'];
        $data['extension_category_list'] = $category['list'];

        // Get License
        $data['license'] = $this->getLicense($dom, $data);

        // Get License Period
        $license_period = $this->getLicensePeriod($dom, $data);
        $data['license_period'] = $license_period['license_period'];
        $data['license_period_list'] = $license_period['list'];

        return $data;
    }

    // Count pagination pages
    public function countPagination($dom) {
        $pagination = $dom->find('.pagination a');

        $pages = array();
        foreach ($pagination as $link) {
            if (strpos($link->href, 'page=')) {
                $page = explode('&' ,$link->href);
                $page = array_pop($page);
                $page = explode(';', $page);
                $page = array_pop($page);
                $pages[] = $page;
            }
        }

        $pages = array_unique($pages);
        $count = count($pages);
        $count += 1;

        return $count;

    }

    // Get id for add new extension
    public function getRandomId($dom) {
        $mas = array();

        // Find table with id 'extension-list'
        $table = $dom->find('table#extension-list');

        // Get child tag <tbody>
        $tbody = $table[0]->children[1];

        // Get mas with extensions
        foreach ($tbody->children as $tr) {
            $name = $tr->children[0]->plaintext;
            $status = trim($tr->children[1]->children[0]->plaintext);
            $date = $tr->children[2]->plaintext;
            $link = $tr->children[3]->children[0]->href;

            $extension_id = $this->getExtensionId($link);

            return $extension_id;
        }
    }

    public function getInfoForAdd($dom) {

        // Get data
        $data = array();

        foreach ($dom->find('input') as $input){
            if($input->type == '' || $input->type == 'text' || $input->type == 'hidden'){
                $data[$input->name] = str_replace("&amp;","&",$input->value);
            }
        }

        foreach ($dom->find('input[checked]') as $input){


            if (strpos($input->name, '[]') !== false) {
                $input->name = str_replace('[]', '', $input->name);
                if(!isset($data[$input->name])){
                    $data[$input->name] = array();
                }
                $data[$input->name][] = $input->value;
            }else{
                $data[$input->name] = $input->value;
            }


        }

        foreach ($dom->find('textarea') as $input){
            $data[$input->name] = str_replace("&amp;","&",$input->innertext);
        }

        foreach ($dom->find('select') as $input){
            if(isset($input->find('option[selected]', 0)->value)){
                $data[$input->name] = $input->find('option[selected]', 0)->value;
            }else{
                $data[$input->name] = '';
            }
        }

        // Compatibility
        $compatibility = $this->getCompatibility($dom, $data);
        $compatibility = $compatibility['list'];

        // License Period
        $license_period = $this->getLicensePeriod($dom, $data);
        $license_period = $license_period['list'];

        // Category
        $category = $this->getCategory($dom, $data);
        $category = $category['list'];

        return ['compatibility' => $compatibility, 'category' => $category, 'license_period' => $license_period];

    }


    // Auxiliary methods for get One Extension information
    public function getImage($dom) {
        $img = $dom->find('#thumb-image');
        if ($img[0]->src === 'https://opencart-image.s3.amazonaws.com/cache/-resize-150x150.jpg') {
            return 'https://image.opencart.com/cache/58242ebb76870-resize-150x150.jpg';
        } else {
            return $img[0]->src;
        }
    }

    public function getBanner($dom) {
        $img = $dom->find('#thumb-banner');
        if ($img[0]->src === 'https://opencart-image.s3.amazonaws.com/cache/-resize-150x150.jpg') {
            return 'https://image.opencart.com/cache/58242ebb76870-resize-150x150.jpg';
        } else {
            return $img[0]->src;
        }
    }

    public function getCompatibility($dom, $data) {
        $div = $dom->find('.well-sm');

        $mas = array();
        foreach ($div[0]->children as $child) {
            $text = trim($child->children[0]->plaintext);
            $value = $child->children[0]->children[0]->value;
            $mas += [$value => $text];
        }

        $compatibility_mas = array();

        foreach ($data['extension_download[0][download]'] as $check) {
            if (array_key_exists($check, $mas)) {
                $compatibility_mas[] = $mas[$check];
            }
        }

        return ['compatibility' => $compatibility_mas, 'list' => $mas];
    }

    public function getCategory($dom, $data) {
        $select = $dom->find('#input-category');

        $mas = array();
        foreach ($select[0]->children as $option) {
            $value = $option->value;
            $text = $option->plaintext;
            if ($text === '') {
                $text = 'No category';
            }
            $mas += [$value => $text];
        }

        $category = '';

        foreach ($mas as $key => $value) {
            if ($key == $data['extension_category_id']) {
                $category = $value;
                break;
            }
        }

        return ['category' => $category, 'list' => $mas];
    }

    public function getLicense($dom, $data) {
        $select = $dom->find('#input-license');

        $mas = array();
        foreach ($select[0]->children as $option) {
            $value = $option->value;
            $text = $option->plaintext;
            $mas[$value] = $text;
        }

        $license = '';

        foreach ($mas as $key => $value) {
            if ($key == $data['license']) {
                $license = $value;
                break;
            }
        }

        return $license;
    }

    public function getLicensePeriod($dom, $data) {
        $select = $dom->find('#input-license-period');

        $mas = array();
        $list = array();
        foreach ($select[0]->children as $option) {
            $value = $option->value;
            $text = $option->plaintext;
            $mas[$value] = $text;
            array_push($list, $text);
        }

        $license_period = '';

        foreach ($mas as $key => $value) {
            if ($key == $data['license_period']) {
                $license_period = $value;
                break;
            }
        }

        if ($license_period === '') {
            $license_period = 'No license period';
        }

        return ['license_period' => $license_period, 'list' => $list];
    }

    public function getAlertPublishNotify($dom, $data) {
        $divs = $dom->find('div.radio');
        $mas = array();
        foreach ($divs as $div) {
            foreach ($div->children as $child) {
                $text = trim($child->plaintext);
                $name = $child->children[0]->name;
                $value = $child->children[0]->value;

                if (isset($mas[$name])) {
                    $mas[$name] += [$value => $text];
                } else {
                    $mas[$name] = [$value => $text];
                }

            }
        }

        foreach ($mas as $key => $value) {
            $data[$key] = $value[$data[$key]];
        }

        return $data;
    }

}