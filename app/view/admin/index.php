<?php
require_once 'head.php';
?>

<div class="main">
    <?php require_once 'menu.php'; ?>
    <div class="right">
        <div class="add_prod">
            <h3>Thêm sản phẩm</h3><br>
            <form action="<?php echo URLROOT ?>/admin/newProduct" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder=" Tên sản phẩm">
                <input type="number" name="gia" placeholder="giá">
                <input type="file" name="file" placeholder="chọn file">
                <select name="category" id="">
                    <?php foreach ($data['category'] as $i){ ?>
                            <option value="<?php echo $i->ma_dm ?>"><?php echo $i->ten_dm; ?></option>
                        <?php } ?>
                </select>
                <textarea name="mota" id="" cols="30" rows="20" >

                </textarea>
                <button type="submit">
                    Đăng
                </button>
            </form>
        </div>
    </div>
</div>