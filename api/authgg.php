<?php
if (!isset($_SESSION))
{
    session_start();
}
class AuthGG
{

    private static $certkey = "sha256//tiYvhtK5CL1cwrBCLCdXqpiEW0iNAo/PuASOr4aOsLg=";
    private static $api = "https://api.auth.gg/php/";

    public static function error($message)
    {
        echo '<div class="alert alert-solid alert-danger mg-b-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <strong>Error:</strong><br>' . $message . '</b>.
          </div>';
    }
    
    public static function success($message)
    {
        echo '<div class="alert alert-solid alert-success mg-b-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <strong>Success:</strong><br>' . $message . '</b>.
          </div>';
    }

    public static function Initialize($aid, $secret)
    {
        $ch = curl_init(self::$api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_PINNEDPUBLICKEY, self::$certkey);
        $_SESSION["aid"] = $aid;
        $_SESSION["secret"] = $secret;
        $values = 
        [
        	"type" => "start", 
        	"aid" => $aid, 
        	"secret" => $secret
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, $values);
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result);
        switch ($data->status)
        {
            case "failed":
            die(AuthGG::error($data->info));
            break;
            case "success":
            break;
            default:
            break;
        }
    }
    public static function Login($username, $password)
    {
        $ch = curl_init(self::$api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_PINNEDPUBLICKEY, self::$certkey);
        $values = 
        [
        "type" => "login", 
        "username" => $username, 
        "password" => $password, 
        "aid" => $_SESSION["aid"], 
        "secret" => $_SESSION["secret"]
    	];
        curl_setopt($ch, CURLOPT_POSTFIELDS, $values);
        $data = json_decode(curl_exec($ch));
        curl_close($ch);
        switch ($data->info)
        {
            case "time expired":
                AuthGG::error("Your subscription has expired!");
                return false;
            case "invalid login":
                AuthGG::error("Your credentials are invalid!");
                return false;
            case "user does not exist":
                AuthGG::error("User does not exist!");
                return false;
            case "success":
                $_SESSION["username"] = $data->username;
                $_SESSION["email"] = $data->email;
                $_SESSION["expiry"] = $data->expiry;
                $_SESSION["rank"] = $data->rank;
                $_SESSION["variable"] = $data->variable;
                $_SESSION["lastlogin"] = $data->lastlogin;
                return true;
            default:
            break;
        }
    }
    public static function Register($username, $password, $email, $license)
    {
        $ch = curl_init(self::$api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_PINNEDPUBLICKEY, self::$certkey);
        $values = 
        [
        	"type" => "register", 
        	"username" => $username, 
        	"password" => $password, 
        	"email" => $email, 
        	"license" => $license, 
        	"aid" => $_SESSION["aid"], 
        	"secret" => $_SESSION["secret"]
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, $values);
        $data = json_decode(curl_exec($ch));
        curl_close($ch);
        switch ($data->info)
        {
            case "invalid license":
                AuthGG::error("License is invalid or already used!");
                return false;
            case "user exists":
                AuthGG::error("Username has been taken!");
                return false;
            case "email used":
                AuthGG::error("Email has been taken!");
                return false;
            case "register success":
                AuthGG::success($username . ' has successfully registered!');
                return true;
            default:
            break;
        }
    }
    public static function Extend($username, $password, $license)
    {
        $ch = curl_init(self::$api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_PINNEDPUBLICKEY, self::$certkey);
        $values = 
        [
        	"type" => "extend", 
        	"username" => $username, 
        	"password" => $password, 
        	"license" => $license, 
        	"aid" => $_SESSION["aid"], 
        	"secret" => $_SESSION["secret"]
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, $values);
        $data = json_decode(curl_exec($ch));
        curl_close($ch);
        switch ($data->info)
        {
            case "invalid details":
                AuthGG::error("User to extend does not exist!");
                return false;
            case "invalid license":
                AuthGG::error("The license has already been used or is invalid!");
                return false;
            case "extend success":
                AuthGG::success($username . ' has successfully been extended!');
                return true;
            default:
                die($result);
            break;
        }
    }
    public static function Log($action)
    {
        if (empty($_SESSION['username']))
        {
            $_SESSION['username'] = "NONE";
        }
        $ch = curl_init(self::$api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_PINNEDPUBLICKEY, self::$certkey);
        $values = 
        [
        	"type" => "log", 
        	"username" => $username, 
        	"action" => $action, 
        	"aid" => $_SESSION["aid"], 
        	"secret" => $_SESSION["secret"]
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, $values);
        curl_exec($ch);
        curl_close($ch);
    }
}

