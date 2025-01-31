<?php




class HandleAPI
{

    protected $api_host;
    protected $port;
    protected $user_name;
    protected $access_key;
    protected $token;
    function __construct($name, $access_key)
    {
        $this->api_host = 'localhost';
        $this->port = '8080';
        $this->user_name = $name;
        $this->access_key = $access_key;
    }

    public function check_connection()
    {
        try {
            $api_connection = $this->send_get_request("http://localhost:8080/requests/connection");
            $json_data = json_decode($api_connection);
            if (!empty($json_data[0])) {
                return $this->apiAthentication();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function registerClient()
    {
    }

    private function apiAthentication()
    {
        $apiData = ["user_name" => $this->user_name, "key" => $this->access_key];
        $json_data = json_encode($apiData);
        $auth = $this->send_post_request($this->api_host . ":" . $this->port . "/auth/logIn", $json_data);
        return $apiData[0];
        return [json_decode($auth)];
        

    }

    private function sendData()
    {
    }

    private function getData()
    {
    }
    static function send_data()
    {
        $request_issues = [];
        array_push($request_issues, self::send_user_data(), self::send_crops_data(), self::send_varieties_data(), self::send_growers_data(), self::send_farm_data());

        return $request_issues;
    }

    static function send_user_data()
    {
        global $con;
        $sql = "SELECT * FROM `user`
       INNER JOIN usertype ON usertype.user_type_ID =user.user_type_ID WHERE `account_status`='active'";

        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $jsonData = ["id" => $row['user_ID'], "fullname" => $row["fullname"], "email" => $row["email"], "password" => $row["password"], "profilePicture" => $row["profile_picture"]];
                $apiData = json_encode($jsonData);
                $issue = self::send_post_request(self::$api_host . ":" . self::$api_host . "/requests/user", $apiData);
            }

            return $issue;
        } else {

            return "error on user";
        }
    }

    static function send_crops_data()
    {
        global $con;

        $sql = "SELECT * FROM `crop`";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $jsonData = ["crop_id" => $row['crop_ID'], "crop_name" => $row["crop"]];
                $apiData = json_encode($jsonData);

                $issue = self::send_post_request(self::$api_host . ":" . self::$api_host . "/requests/crop", $apiData);
            }

            return $issue;
        } else {

            echo "error on crop";
        }
    }

    static function send_varieties_data()
    {

        global $con;

        $sql = "SELECT * FROM `variety`";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $jsonData = ["variety_id" => $row['variety_ID'], "variety_name" => $row["variety"], "crop_id" => $row["crop_ID"]];
                $apiData = json_encode($jsonData);

                $issue = self::send_post_request(self::$api_host . ":" . self::$api_host . "/requests/variety", $apiData);
            }

            return $issue;
        } else {

            echo "error on crop";
        }
    }

    static function send_growers_data()
    {

        global $con;

        $sql = "SELECT * FROM `creditor` WHERE `source` = 'internal' AND `creditor_status`='active'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $jsonData = ["grower_id" => $row['creditor_ID'], "fullname" => $row["name"], "phone" => $row["phone"]];
                $apiData = json_encode($jsonData);

                $issue = self::send_post_request(self::$api_host . ":" . self::$api_host . "/requests/grower", $apiData);
            }

            return $issue;
        } else {

            echo "error on grower_data";
        }
    }

    static function send_farm_data()
    {
        global $con;

        $sql = "SELECT `farm_ID`, `Hectors`,crop.crop_ID,variety.variety_ID,
        `class`, `region`, `district`, `area_name`, `address`, `physical_address`,
        `EPA`,creditor.name,creditor.creditor_ID, farm.registered_date, `previous_year_crop`,
         `other_year_crop`, `main_lot_number`, `main_quantity`, 
         `male_lot_number`, `male_quantity`, `female_lot_number`, 
         `female_quantity` FROM `farm` INNER JOIN crop
        ON farm.crop_species = crop.crop_ID INNER JOIN variety 
        ON farm.crop_variety = variety.variety_ID INNER JOIN 
        creditor ON farm.creditor_ID = creditor.creditor_ID WHERE `order_status`='order_processed'";

        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $jsonData = ["farm_id" => $row['farm_ID'], "hectors" => $row["Hectors"], "region" => $row["region"], "district" => $row["district"], "area_name" => $row["area_name"], "address" => $row["address"], "physical_address" => $row["physical_address"], "epa" => $row["EPA"], "crop_id" => $row["crop_ID"], "variety_id" => $row["variety_ID"], "grower_id" => $row["creditor_ID"]];
                $apiData = json_encode($jsonData);

                $issue = self::send_post_request(self::$api_host . ":" . self::$api_host . "/requests/farm", $apiData);
            }

            return $issue;
        } else {


            echo "error on farm_data";
        }
    }


    private function send_post_request($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, true);

        $response = curl_exec($ch);

        if ($response == false) {
            echo 'Error: ' . curl_error($ch);
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode === 200) {
                return $response;
            } else {
                return 'HTTP Error: ' . $httpCode;
            }
        }

        curl_close($ch);
    }


    private function send_get_request($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        $response = curl_exec($ch);

        if ($response == false) {
            echo 'Error: failed to connect ' . curl_error($ch);
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode === 200) {
                return $response;
            } else {
                return 'HTTP Error: ' . $httpCode;
            }
        }

        // curl_close($ch);
    }
}
