<?php
include "DB.php";

class PanelHelper
{
    private $db;

    public function __construct(){
        $this->db = new DB();
    }

    /**
     * Convert English number to Persian Number
     * @param $number
     * @return int|string|string[]
     */
    function fa_number($number){
        if(!is_numeric($number) || empty($number))
            return '۰';
        $en = array("0","1","2","3","4","5","6","7","8","9");
        $fa = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
        return str_replace($en, $fa, $number);
    }

    /**
     * Get total wallpaper count in database
     * @return int|string|string[]
     */
    public function getTotalWallpapersCount(){
        $sql = "SELECT COUNT(*) FROM wallpapers";
        $result = $this->db->runQuery($sql);
        while ($row = mysqli_fetch_assoc($result)){
            return $this->fa_number($row['COUNT(*)']);
        }
    }

    /**
     * Get Total Wallpapers Downloads
     * @param $detail Wich Details you want to get ['downloads','views','likes']
     * @return int|string|string[]
     */
    public function getTotalWallpapersDetails($detail){
        $result = $this->db->Select("wallpapers");
        $details = "0";
        while ($row = mysqli_fetch_assoc($result)){
            $details += $row[$detail];
        }
        return $this->fa_number($details);
    }

}