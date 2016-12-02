<?php
/**
 * Created by PhpStorm.
 * User: Nasolo
 * Date: 30/11/2016
 * Time: 17:52
 */

//namespace Olocounter\Counter;


class Counter {

    private $ip ;
    private $userAgent ;

    private $sessionLifeTime ;


    /**
     * constructor
     * @param int $_sessionLifeTime  time session left between to considerate new visit
     */
    public function __construct($_sessionLifeTime = 5 )
    {

        //save visitor from frontpage only
        if (!is_admin()){
            $this->ip = self::getIpAddress();
            $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
            $this->sessionLifeTime = $_sessionLifeTime;
            $this->page = $_SERVER['SCRIPT_NAME'];

            if($this->isNewVisit()) {
                $this->addNewVisitor();
            }
        }

    }


    private function addNewVisitor()
    {
        global $wpdb;

        $wpdb->insert(
            $wpdb->prefix.'olovisitors',
            array(
                'ip'=> $this->ip,
                'visit_date' => date('Y-m-d H:i:s'),
                'useragent' => $this->userAgent
            )
        );
    }


    /**
     * check if the visit new or not
     *
     * @return <bool> true or false
     *
     */
    private function isNewVisit()
    {
        global $wpdb;
        $_isNewVisit = true;
        $_query = "SELECT * FROM {$wpdb->prefix}olovisitors where ip = '".$this->ip."' AND useragent = '".$this->userAgent."'" ;
        $_query .= " AND visit_date > date_sub( now( ) , INTERVAL ".$this->sessionLifeTime." MINUTE )" ;
        $_result = $wpdb->get_results($_query);

        if(count($_result) > 0){
            $_isNewVisit = false;
        }

        return $_isNewVisit;

    }

    /**
     * get ip adress of the client
     * @return mixed
     */
    public  static function getIpAddress() {
        // check for shared internet/ISP IP
        if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        // check for IPs passing through proxies
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check if multiple ips exist in var
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($iplist as $ip) {
                    if (validate_ip($ip))
                        return $ip;
                }
            } else {
                if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
            return $_SERVER['HTTP_X_FORWARDED'];
        if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
            return $_SERVER['HTTP_FORWARDED_FOR'];
        if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
            return $_SERVER['HTTP_FORWARDED'];
        // return unreliable ip since all else failed
        return $_SERVER['REMOTE_ADDR'];
    }









} 