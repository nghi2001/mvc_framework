<?php
require_once 'head.php';
?>

<div class="main">
    <?php require_once 'menu.php'; ?>
    <div class="right">
        <table class="list_prod">
            <tr>
                <th>ma_hd</th>
                <th>mã khách</th>
                <th>ngày mua</th>
                <th>tổng tiền</th>
                <th>tình trạng</th>
                <th></th>
            </tr>
            
            <?php  foreach($data['hd'] as $obj) {?>
                <tr id="<?php echo $obj->ma_hd; ?>">
                    <td><?php echo $obj->ma_hd; ?></td>
                    <td><?php echo $obj->ma_khach ?></td>
                    <td><?php echo $obj->ngay_mua?></td>
                    <td><?php echo $obj->tong_tien ?></td>
                    <td class="<?php echo $obj->ma_hd ?>"><?php echo $obj->tinh_trang ?></td>
                    <td>
                        <button onclick="deleteProd('<?php echo $obj->ma_tt; ?>',<?php echo $obj->ma_hd ?>)">Cập nhật</button>
                    </td>
                </tr>
            <?php } ?>
            
    </table>
    </div>
</div>

<script>
    function deleteProd( tinh_trang, ma_hd){
        $.ajax({
                type: "POST",
                url: 'http://localhost/DU_AN_MAU/mvc_project/admin/updatebill',
                data: 
                {
                    ma_hd: ma_hd,
                    tinh_trang : tinh_trang
                }
                ,
                success: function(data){
                    $('.'+ma_hd).html(data);
                }
                });
    }
</script>