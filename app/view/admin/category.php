<?php
require_once 'head.php';
?>

<div class="main">
    <?php require_once 'menu.php'; ?>
    <div class="right">
        <div class="add_category">
            <h3>Thêm danh mục</h3>
            <form action="<?php echo URLROOT ?>/admin/addCategory" method="post">
                <input type="text" name="name" placeholder="Nhập tên danh mục" id=""><br><br>
                <span class="error"><?php echo $data['error']; ?></span><br>
                <button type="submit">Thêm Danh Mục</button>
            </form>
        </div>

        <div class="list">
            <h3>Danh Mục</h3>
            <table class="list_prod">
                <tr>
                    <th>Mã Danh Mục</th>
                    <th>Tên Danh Mục</th>
                    <th></th>
                </tr>
                <?php foreach($data['list'] as $obj) { ?>
                    <tr id= '<?php echo $obj->ma_dm; ?>'>
                        <td><?php echo $obj->ma_dm; ?></td>
                        <td><?php echo $obj->ten_dm; ?></td>
                        <td><button onclick="deleteProd(<?php echo $obj->ma_dm; ?>)">Xóa</button></td>
                    </tr>
                <?php }; ?>
            </table>
        </div>
    </div>
</div>
<script>
    function deleteProd(id){
        $.ajax({
                type: "POST",
                url: 'http://localhost/DU_AN_MAU/mvc_project/admin/deleteCategory',
                data: 
                {id: id}
                ,
                success: function(data){
                    $('#'+id).remove();
                    alert(data);
                }
                });
    }
</script>