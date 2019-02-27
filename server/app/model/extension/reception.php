<?php

require_once DIR_SYSTEM.'library/engine/model.php';

class Reception extends Model {

    // system/library/opencart.php
    private $opencart;

    // Get all extensions from current page / by default - 1st
    public function getExtensions($page = 1) {
        $this->opencart = $this->registry->get('opencart');

        // Request to the site
        $this->opencart->request('get', 'account/extension&member_token='.$this->opencart->member_token.'&page='.$page);

        // Catch response
        return $this->opencart->curl->response;
    }

    // Get data of one Extension
    public function getExtension($extension_id){
        $this->opencart = $this->registry->get('opencart');

        // Send request on the site
        $this->opencart->request('get', 'account/extension/edit&extension_id='.$extension_id);

        // Catch the response
        return $this->opencart->curl->response;

    }

    // Edit extension
    public function editExtension($extension_id, $data) {
        $this->opencart = $this->registry->get('opencart');
        $history = array(
            'Update to new version',
            'Fix minor bug',
            'Fix bug',
            'Bug fix',
            'Update code',
            'Update description',
            'New version',
            'Fix small issue',
            'Delete mistake in text',
            'Correct language',
            'Correct version',
            'Correct text',
            'Update image',
            'Updating zip',
            'fixes',
            'minor fixes',
        );
        $data['history'] = $history[array_rand($history)];
        $this->opencart->request('post', 'account/extension/edit&extension_id='.$extension_id, $data);
    }

    // Upload file to opencart
    public function uploadFile(){

        //result file_id
    }

    // Delete Extension
    public function deleteExtension($extension_id) {
        $this->opencart = $this->registry->get('opencart');

        // Send request on the site
        $this->opencart->request('post', 'account/extension/delete&member_token='.$this->opencart->member_token.'&extension_id='.$extension_id);

        // Catch the response
        return $this->opencart->curl->response;
    }

    // add extension
    public function addExtension($data){

        //result extension_id
    }

    public function refreshExtension($extension_id){
        $data = $this->getExtensionData($extension_id);
        //$data['name'] = 'Cart Related Products'; //Blog Module PRO
        $history = array(
            'Update to new version',
            'Fix minor bug',
            'Fix bug',
            'Bug fix',
            'Update code',
            'Update description',
            'New version',
            'Fix small issue',
            'Delete mistake in text',
            'Correct language',
            'Correct version',
            'Correct text',
            'Update image',
            'updateing zip',
            'fixes',
            'minor fixes',
        );
        $data['history'] = $history[array_rand($history)];
        $this->request('post', 'account/extension/edit&extension_id='.$extension_id, $data, true);

        return $data;
    }

}