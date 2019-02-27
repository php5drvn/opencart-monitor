<?php
require_once DIR_SYSTEM.'library/engine/controller.php';

use \Curl\Curl;

class SiteController extends Controller {

    public $curl = '';
    private $url = 'https://ru.wikipedia.org/wiki/';
    private $cookieFile = '';
    private $userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36 FirePHP/4Chrome';
    public $member_token = '';

    public $month = array(
        '01' => 'января',
        '02' => 'февраля',
        '03' => 'марта',
        '04' => 'апреля',
        '05' => 'мая',
        '06' => 'июня',
        '07' => 'июля',
        '08' => 'августа',
        '09' => 'сентября',
        '10' => 'октября',
        '11' => 'ноября',
        '12' => 'декабря'
    );

    public function request($method, $query, $data = array(), $follow = false) {
        $this->curl->setUserAgent($this->userAgent);
        $this->curl->setCookieFile($this->cookieFile);
        $this->curl->setCookieJar($this->cookieFile);
        if($follow){
            $this->curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
        }


        $query = $this->url.$query;
        if($this->member_token){
            $query .= '&member_token='.$this->member_token;
        }

        $this->curl->$method($query, $data);
    }

    public function index() {

        $this->curl = new Curl();

        $this->registry->get('load')->model('extension/reception');
        $this->registry->get('load')->model('extension/extension');

        $day = date('j');
        $month = date('m');
        $month = $this->month[$month];

        $this->request('get', $day.'_'.$month);
        var_dump($this->curl->response);

    }

}