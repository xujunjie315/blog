<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件

/**
 * @param string $address
 * @return string
 */
function http($url, $method = 'get', $data = array()) {
    $curl = curl_init();
    if (strtoupper($method) === 'POST') {
        curl_setopt($curl, CURLOPT_POST, TRUE);
        $data = http_build_query($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

/**
 * 对密码进行hash
 * @author huyan <walkonthemarz@gmail.com>
 * @param string $pass
 * @return string | false
 */
function pass_hash($pass) {
    return password_hash($pass, PASSWORD_BCRYPT);
}

/**
 * 对密码进行校验
 * @author huyan <walkonthemarz@gmail.com>
 * @param string $pass:明文密码
 * @param string $hash：比对的hash值
 * @return boolean
 */
function pass_verify($pass, $hash) {
    return password_verify($pass, $hash);
}

/**
 * 可逆加密函数
 * @author huyan <walkonthemarz@gmail.com>
 * @param string $data 
 * @param string $pass
 * @param string $cipher
 * @param string $iv
 * @return string | false
 */
function encrypt_id($data, $pass = 'ak48rimag', $cipher = 'aes-256-ofb', $iv = 'kT4Fb6dGbY7sqxDV') {
    return openssl_encrypt($data, $cipher, $pass, 0, $iv);
}

function list_encrytion($list) {
    array_walk($list, function(&$v) {
        $v['id'] = \encrypt_id($v['id']);
    });
    return $list;
}

/**
 * 可逆解密函数
 * @author huyan <walkonthemarz@gmail.com>
 * @param string $data
 * @param string $pass
 * @param string $cipher
 * @param string $iv
 * @return string | false
 */
function decrypt_id($data, $pass = 'ak48rimag', $cipher = 'aes-256-ofb', $iv = 'kT4Fb6dGbY7sqxDV') {
    return openssl_decrypt($data, $cipher, $pass, 0, $iv);
}
