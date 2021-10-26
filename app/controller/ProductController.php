<?php 

class ProductController extends Controller{

    public function __construct()
    {
        $this->productModel = $this->model('Product');
    }

    public function index(){
        $data['list_prod'] = $this->productModel->getAllProduct();

        return $this->view('product', $data);
    }

    public function cart(){

        return $this->view('product/cart');
    }

    public function themhoadon(){
        if(empty($_SESSION['user_info'])){
            return header('Location: '.URLROOT.'/product/cart');
            
        }
        $tongtien =$_POST['tong'];
        $data = [
            'ma' => $_POST['ma'],
            'soluong' => $_POST['soluong'],
            'gia' => $_POST['gia']
        ];
        $insert = $this->productModel->createBill($_SESSION['user_info']['user_id'], $tongtien);


        $this->productModel->detailbill($insert['id_hd'], $data);
    }

    public function detail($id){
        $product = $this->productModel->getProduct($id);
        $comments = $this->productModel->getCommentByIdProduct($id);
        $data = [
            'product' => $product,
            'comments' => $comments
        ];
        return $this->view('product/detail',$data);
    }

    public function addComment(){
        if(isset($_SESSION['user_info'])){
            $ma_khach = $_POST['ma_khach'];
            $ma_sp = $_POST['ma_sp'];
            $nodung = $_POST['comment'];
            $data = [
                'ma_khach' => $ma_khach,
                'ma_sp' => $ma_sp,
                'noidung' => $nodung
            ];
            $result = $this->productModel->insertComment($data);
            if($result){
                echo json_encode($data);
            }
        }else{
            return false;
        }
    }
}