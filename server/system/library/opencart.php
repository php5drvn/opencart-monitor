<?php
use \Curl\Curl;

class Opencart {

    public $curl = '';
    private $url = 'https://www.opencart.com/index.php?route=';
    private $cookieFile = '';
    private $userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36 FirePHP/4Chrome';
    public $member_token = '';

    public function __construct($data){
        $this->cookieFile = $data['cookie'];
        $this->curl = new Curl();

        if(isset($_SESSION['member_token'])){
            $this->member_token = $_SESSION['member_token'];
            //return false;
        }

        $this->request('post', 'account/login', array(
            'email'       => $data['login'],
            'password'    => $data['password'],
            'redirect'    => ''
             
        ), true);


        if ($this->curl->error) {
              echo 'Error: ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n";
              exit;
        }
        $info = $this->curl->getInfo();

        parse_str($info['url'], $value);
        if(empty($value['member_token'])){
            parse_str($info['redirect_url'], $value);
        }
        $this->member_token = $value['member_token'];
        $redirect_url = $info['redirect_url'];

        $this->request('post', 'account/security', array(
            'member_token'      => $this->member_token,
            'pin'               => $data['pin'],
            'redirect'          => ''
        ));

        if ($this->curl->error) {
              echo 'Error: ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n";
              exit;
        }else{
            $_SESSION['member_token'] = $this->member_token;
        }


        $this->request('get', 'account/account');
    }

    public function request($method, $query, $data = array(), $follow = false){
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

}