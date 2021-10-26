<?php
require_once 'head.php';
?>

<div class="main">
    <?php require_once 'menu.php'; ?>
    <div class="right">
        <table class="list_prod">
            <tr>
                <th>Mã SP</th>
                <th>tên san pham</th>
                <th>mã dm</th>
                <th>giá</th>
                <th>ảnh</th>
                <th>ngày</th>
                <th></th>
            </tr>
            
            <?php foreach($data as $obj) {?>
                <tr id="<?php echo $obj->ma_sp; ?>">
                    <td><?php echo $obj->ma_sp ?></td>
                    <td><?php echo $obj->ten_hang ?></td>
                    <td><?php echo $obj->loai_hang ?></td>
                    <td><?php echo $obj->gia ?></td>
                    <td><img src="<?php echo $obj->anh ?>"></td>
                    <td><?php echo $obj->ngay ?></td>
                    <td><button onclick="deleteProd(<?php echo $obj->ma_sp; ?>)">Xóa</button></td>
                </tr>
            <?php } ?>
            
    </table>
    </div>
</div>

<script>
    function deleteProd(id){
        $.ajax({
                type: "POST",
                url: 'http://localhost/DU_AN_MAU/mvc_project/admin/deleteProd',
                data: 
                {id: id}
                ,
                success: function(data){
                    $('#'+id).remove();

                }
                });
    }
</script>