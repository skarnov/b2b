<?php

namespace Config;

class CaptchaValidation
{
    public function verifyrecaptchaV3(string $str, ?string &$error = null): bool
    {
        $secretkey = '6LdcEL4jAAAAAGm-oSksFKE-JqAwerfh7tCmJD3J';
        if (($str) && !empty($str)) {
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretkey . "&response=" . $str . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
            $responseData = json_decode($response);
            $score = 0.6;
            if ($responseData->success && $responseData->score > $score) {
                return true;
            }
        }
        $error = "Invalid captacha";
        return false;
    }
}