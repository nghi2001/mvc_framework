<?php

use Google\Service\Bigquery\Model;

class AdminController extends Controller{
    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->productModel = $this->model('Product');
        $checkuser = $this->userModel->checkRole($_SESSION['user_info']['user_id']);
        if($checkuser == false){
            header('Location: '.URLROOT);
        }
    }

    public function index(){
        $category = $this->productModel->getCategory();
        $data = [
            'category' => $category
        ];
        return $this->view('admin/index',$data);
    }

    public function newProduct(){
        
        $target_dir =__DIR__.'/../../public/img/product/';
        $file_name = $_FILES['file']['name'];
        $target_file = $target_dir.basename($file_name);
        $data = [
            'name' => $_POST['name'],
            'gia' => $_POST['gia'],
            'anh' => URLROOT.'/public/img/product/'.$file_name,
            'dm' => $_POST['category'],
            'mota' => $_POST['mota']
        ];

        if(
            empty($data['name']) ||
            empty($data['gia']) ||
            empty($data['anh']) ||
            empty($data['dm']) ||
            empty($data['mota'])) {
                header('Location: '.URLROOT.'/admin');
            }
        else{
            
            if(move_uploaded_file($_FILES['file']['tmp_name'], $target_file)){
                $this->productModel->insertProduct($data);
                header("Location: ".URLROOT.'/admin');
            }
            
            }
    }

    public function listProduct(){
        $list = $this->productModel->getAllProduct();
        

        return $this->view('admin/listprod',$list);
    }

    public function deleteProd(){
        $id = $_POST['id'];
        
        $this->productModel->deleteProductById($id);
        return 'a';
    }

    public function addCategory(){
        $listCategory = $this->productModel->getCategory();

        $data = [
            'list' => $listCategory,
            'error' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $danh_muc = $_POST['name'];
            if(empty($danh_muc)){
                $data['error'] = 'Bạn phải nhập đầy đủ thông tin';
                return $this->view('admin/category', $data);
            }else{
                $this->productModel->insertCategory($danh_muc);
                header("Location: ".URLROOT.'/admin/addCategory');
            }
        }

        return $this->view('admin/category', $data);
    }

    public function deleteCategory(){
        $id = $_POST['id'];
        $this->productModel->deleteCategory($id);
    }

    public function hoadon(){
        $hd = $this->productModel->getAllHd();
        $data = [
            'hd' => $hd,
        ];
    

        return $this->view('admin/bill', $data);
    }

    public function updatebill(){
        $tinh_trang = $this->productModel->doiTinhtrang($_POST['tinh_trang'], $_POST['ma_hd']);
        echo $tinh_trang;
    }

    public function chart(){
        $doanh_so = $this->productModel->getTotalSales();
        $top_product = $this->productModel->getTopProductSales();
        
        $data = [
            'doanh_so' => $doanh_so,
            'top_product' => $top_product
        ];
        return $this->view('admin/bieudo',$data);
    }
}