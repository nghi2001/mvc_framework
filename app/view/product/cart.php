<?php
    require_once APPROOT.'/view/Layout/head.php';

    require_once APPROOT.'/view/Layout/header.php';


    require_once APPROOT.'/view/Layout/navigation.php';

?>
<div class="main_content">
    <div class="table-responsive container">
    <table class="table caption-top">
    <caption class="text-secondary" style="font-size: 30px; text-align: center;">Danh sách giỏ hàng của bạn</caption>
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Tên sản phẩm</th>
      <th scope="col">ảnh</th>
      <th scope="col">số luọng</th>
      <th scope="col" >giá</th>
    </tr>
    
  </thead>
  <tbody id="tbody">
    <form action="<?php echo URLROOT ?>/product/themhoadon" method="post">
    <script>
        var list_prod = localStorage.getItem('products');
        list_prod = JSON.parse(list_prod);
        list_prod = Object.values(list_prod);
        console.log(list_prod[0].ma);
        for(i=0 ; i< list_prod.length; i++){
        let tr = "<tr>"+
                    "<th scope='row'>"+list_prod[i].ma+"<input type='hidden' name='ma[]' value='"+list_prod[i].ma+"'>"+"</th>"+
                    "<td>"+list_prod[i].decript+"</td>"+
                    "<td><img src='"+list_prod[i].anh+"'></td>"+
                    "<td>"+list_prod[i].inCart+"<input type='hidden' name='soluong[]' value='"+list_prod[i].inCart+"'>"+"</td>"+
                    "<td>"+list_prod[i].cost+"<input type='hidden' name='gia[]' value='"+list_prod[i].cost+"'>"+"</td>"+
                    
                "</tr>";

        document.write(tr);
        }
    </script>
    <tr>
        <td colspan="4" id="tong">Tổng tiền:
            <script>
                var tong = 0;
                for(i=0 ; i< list_prod.length; i++){
                    let gia = parseFloat(list_prod[i].cost)
                    tong+= gia;
        }
        document.write(tong);
        document.write("<input type='hidden' name='tong' value='"+tong+"'>");
            </script>    
        </td>
        <td><button class="btn btn-success" onclick="unset()">Mua hàng</button></td>
    </tr>
    </form>
  </tbody>
    </table>
    </div>        
</div>
<div class="slogan">
    <i class="fa fa-truck" aria-hidden="true"></i>

    <div class="sg-right">
        <h3>Miễn Phí Vận Chuyển Trên Mọi Đơn Hàng</h3>
        <span>hoặc hoàn trả trong 1 giờ</span>
    </div>
</div>
</div>
<button id="roll_to_top">
<i class="fa fa-arrow-up" aria-hidden="true"></i>
</button>
<script src="<?php echo URLROOT.'/public/js/index.js'; ?>"></script>
<script src="<?php echo URLROOT ?>/public/js/product.js"></script>
<?php
    require_once APPROOT.'/view/Layout/footer.php';
?>

<script>
    function unset(){
        localStorage.removeItem('products');
        localStorage.removeItem('cartNumbers');
    }
</script>