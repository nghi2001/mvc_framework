<?php
    require_once APPROOT.'/view/Layout/head.php';

    require_once APPROOT.'/view/Layout/header.php';

    require_once APPROOT.'/view/Layout/banner.php';

    require_once APPROOT.'/view/Layout/navigation.php';

?>
<div class="main_content">
        <section>
            <h2>Sản Phẩm</h2>
            <div class="list_sp">
                

                <?php foreach($data['list_prod'] as $product) {?>
                    <div class="product" data-ma="<?php echo $product->ma_sp ?>">
                    <img src="<?php echo $product->anh ?>" alt="">
                    <div class="detail_prod">
                        <h3><a href="<?php echo URLROOT.'/product/detail/'.$product->ma_sp; ?>"><?php echo $product->ten_hang ?></a></h3>
                        <p data-cost="<?php echo $product->gia ?>">Giá: <?php echo $product->gia ?></p>
                    </div>
                    <button class="add_to_cart">Thêm</button>
                </div>

                <?php } ?>
            </div>
        </section>

        <aside>
            <div class="category">
                <h2>Danh Mục</h2>
                <ul>
                    <li><a href="#">Canon</a></li>
                    <li><a href="#">Sony</a></li>
                    <li><a href="#">Nikon</a></li>
                </ul>
            </div>
        </aside>
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