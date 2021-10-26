<?php
    require_once APPROOT.'/view/Layout/head.php';

    require_once APPROOT.'/view/Layout/header.php';


    require_once APPROOT.'/view/Layout/navigation.php';

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="container">
       
<div class="product_detail">
    <div class="left">
        <img src="<?php echo $data['product']['anh']; ?>" alt="">
    </div>
    <div class="right">
        <h3><?php echo $data['product']['ten_hang'] ;?></h3>
        <p>Giá: <?php echo $data['product']['gia']; ?></p>
        <p>Mô tả: <?php echo $data['product']['mota']; ?></p>
        <p>Ngày đăng: <?php echo $data['product']['ngay'] ?></p>
    </div>
</div>
<br>
<div class="comment">
    <h3>Bình luận</h3>
    <hr>
    <div class="input_comment">
        <img id="avt" src="<?php echo ($_SESSION['user_info']['user_avt']); ?>" data-name="<?php echo $_SESSION['user_info']['user_name'] ?>" alt="">
        <textarea name="send_comment" placeholder="Bình luận của bạn" data-ma="<?php echo $_SESSION['user_info']['user_id']?>" data-masp="<?php echo $data['product']['ma_sp']?>" id="contentcm" ></textarea>
        <button class="btn btn-primary" id="sendcm">Gửi</button>
            
    </div>

    <div class="list_comment">
        <ul id="ul">
            
           <?php foreach($data['comments'] as $comment){ ?>
            <li>
                <div class="comment_user">
                    
                    <img src="<?php echo $comment->anh; ?>" alt="">
                    <div class="comment_content">
                        <p><?php echo $comment->name; ?> <p><?php echo $comment->ngay; ?></p></p>
                        <p><?php echo $comment->noi_dung; ?></p>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
        
    </div>
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
    $("#sendcm").click(function(event){
        event.preventDefault();
        var comment = $("#contentcm").val();
        var ma_khach = $("#contentcm").attr('data-ma');
        var ma_sp = $("#contentcm").attr('data-masp');
        $.ajax({
            type: "POST",
            url: "http://localhost/DU_AN_MAU/mvc_project/product/addComment",
            data:{
                comment : comment,
                ma_khach : ma_khach,
                ma_sp : ma_sp

            },
            success: function(data){
                let anh = $("#avt").attr("src");
                let name = $("#avt").attr("data-name");
                let comment = JSON.parse(data);
                console.log(comment)
                let elementcomment = "<li>"+
                                        "<div class='comment_user'>"+                    
                                        "<img src="+anh+" alt=''>"+
                                        "<div class='comment_content'>"+
                                        "<p>"+name+"</p>"+
                                        "<p>"+comment.noidung+"</p>"+
                                                "</div>"+
                                            "</div>"+
                                        "</li>";
                $("#ul").prepend(elementcomment);
            }

        });
    });
</script>