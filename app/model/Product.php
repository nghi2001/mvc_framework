<?php

class Product{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getCategory(){
        $sql = 'select * from `danh_muc` where 1';
        $this->db->query($sql);
        return $this->db->singleAll();
    }

    public function getProduct($id){
        $sql = "select * from `san_pham` where ma_sp = $id";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function insertProduct($data){
        $sql = "
        INSERT INTO `san_pham`(`loai_hang`, `ten_hang`, `gia`, `anh`, `ngay`, `mota`) 
        VALUES (:dm, :name,:gia,:anh,:ngay,:mota)
        ";
        $this->db->query($sql);
        $this->db->bind(':dm', $data['dm']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':gia', $data['gia']);
        $this->db->bind(':anh', $data['anh']);
        $this->db->bind(':ngay', date('Y-m-d'));
        $this->db->bind(':mota', $data['mota']);

        return $this->db->execute();
    }

    public function getAllProduct(){
        $sql = "
            select * from `san_pham` where 1
        ";
        $this->db->query($sql);
        $result = $this->db->singleAll();
        return $result;
    }

    public function deleteProductById($id){
        $sql = "
                delete from `chi_tiet_hd` where `ma_hang` = :id;                
                delete from `san_pham` where `ma_sp` = :id;
                ";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->execute();
        return true;
    }

    public function insertCategory($data){
        $sql = ' insert into `danh_muc` (`ten_dm`) value (:name)';
        $this->db->query($sql);
        $this->db->bind(":name",$data);
        $this->db->execute();
    }

    public function getProductByIdCategory($id){
        $sql = "
            select `ma_sp` from `san_pham` where `loai_hang` = :id
        ";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        return $this->db->singleAll();
    }

    public function deleteProductByCategory($list_prod, $idsp){
        foreach($list_prod as $list){
            $sql = "
                delete from `chi_tiet_hd` where `ma_hang` = '.$list->id.";
            $this->db->query($sql);
            $this->db->execute();
        }
        $sql = "
            delete from `san_pham` where `san_pham`.`loai_hang` = :id;
            ";
        $this->db->query($sql);
        $this->db->bind(':id', $idsp);
        $this->db->execute();
    }

    public function deleteCategory($id){
        $list_prod = $this->getProductByIdCategory($id);

        $this->deleteProductByCategory($list_prod, $id);
        
        $sql = "
        DELETE FROM `danh_muc` WHERE `ma_dm` = :id
        ";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->execute();
        return gettype($id);

    }

    public function createBill($ma_khach, $total, ){
        $sql = "
        INSERT INTO `hoa_don` (`ma_hd`, `ma_khach`, `ngay_mua`, `tong_tien`, `tinh_trang`) VALUES (NULL, :ma_khach, :ngay_mua, :tong, '1');
        
        ";
        $this->db->query($sql);
        $this->db->bind(':ma_khach', $ma_khach);
        $this->db->bind(':ngay_mua', date('Y-m-d'));
        $this->db->bind(':tong', $total);
        $this->db->execute();

        $sql = "
        SELECT max(`ma_hd`) as id_hd from `hoa_don`
        ";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
    public function detailbill($id, $data){
        for($i=0; $i<count($data['ma']); $i++){
            $sql = "
            INSERT INTO `chi_tiet_hd`(`ma_hd`, `ma_hang`, `so_luong`, `don_gia`)
            VALUES ($id,:ma_hang,:sl,:gia)
            ";
            $this->db->query($sql);
            $this->db->bind(":ma_hang", $data['ma'][$i]);
            $this->db->bind(":sl", $data['soluong'][$i]);
            $this->db->bind(":gia", $data['gia'][$i]);
            $this->db->execute();
            header("Location: ".URLROOT.'/product');
        }
    }
    public function getAllHd(){
        $sql = "SELECT A.ma_hd as ma_hd, A.ma_khach as ma_khach, A.ngay_mua as ngay_mua, A.tong_tien as tong_tien, B.ten as tinh_trang, B.id as ma_tt FROM hoa_don A INNER JOIN `trang_thai` B on A.tinh_trang = B.id;
        ";
        $this->db->query($sql);
        return $this->db->singleAll();
    }

    public function doiTinhtrang($tinh_trang , $id){
        if($tinh_trang == 1){
            $sql = "update `hoa_don` set `tinh_trang` = 2 where ma_hd = :ma_hd";
            $this->db->query($sql);
            $this->db->bind(":ma_hd", $id);
            $this->db->execute();
            return 'đã thanh toán';
        }
        if($tinh_trang == 2){
            $sql = "update `hoa_don` set `tinh_trang` = 1 where ma_hd = :ma_hd";
            $this->db->query($sql);
            $this->db->bind(":ma_hd", $id);
            $this->db->execute();
            return 'chưa thanh toán';
        }
    }

    public function getCommentByIdProduct($id){
        $sql = "
        SELECT C.name, C.anh, B.noi_dung, B.ngay 
        FROM `san_pham` A INNER JOIN `binh_luan` B on A.ma_sp = B.ma_sp INNER JOIN `user_profile` C on B.ma_khach=C.id
        WHERE A.ma_sp=$id;
        ";
        $this->db->query($sql);
        return $this->db->singleAll();
    }

    public function insertComment($data){
            $sql = "INSERT INTO `binh_luan`( `ma_khach`, `ma_sp`, `noi_dung`, `ngay`) 
                VALUES (:ma_khach,:ma_sp,:noidung,:ngay)";
            $this->db->query($sql);
            $this->db->bind(":ma_khach", $data['ma_khach']);
            $this->db->bind(":ma_sp", $data['ma_sp']);
            $this->db->bind(":noidung", $data['noidung']);
            $this->db->bind(":ngay", date("Y-m-d"));
            return $this->db->execute();
    }

    

    public function getTotalSales(){
        $sql = "
        SELECT SUM(tong_tien) as tong_tien, MONTH(ngay_mua) as thang 
        FROM `hoa_don` WHERE YEAR(ngay_mua)=:year AND tinh_trang=2 GROUP BY month(ngay_mua);
        ";
        $this->db->query($sql);
        $this->db->bind(":year", date("Y"));
        return $this->db->singleAll();
    }

    public function getTopProductSales(){
        $sql = "
        SELECT SUM(B.don_gia) as gia, B.ma_hang as ma_sp FROM hoa_don A INNER JOIN chi_tiet_hd B on A.ma_hd=B.ma_hd GROUP BY B.ma_hang ORDER BY SUM(B.don_gia) DESC ;
        ";

        $this->db->query($sql);
        return $this->db->singleAll();
    }
}