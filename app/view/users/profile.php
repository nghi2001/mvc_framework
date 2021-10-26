<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            border: 0;
            margin: 0;
            padding: 0;
        }
        html, body{
            height: 100%;
        }
        main{
            width: 100%;
            height: 100%;
            background-color: rgb(247, 247, 248);
        }
        .container{
            width: 70%;
            height: 70%;
            padding: 10px;
            background-color: #fff;
            border-radius: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 20px #9999;
            display: flex;
            align-items: center;
        }
        .container .left{
            width: 50%;
            height: 100%;
            position: relative;
        }
        .container .left img{
            width: 60%;
            height: 70%;
            position: absolute;
            border-radius: 50% ;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
        }
        .container .left button{
            position: absolute;
            bottom: 0;
            left: 50%;
            transform:  translateX(-50%);
            margin: auto;
            width: 30%;
            height: 30px;
            background-color: #7f8a82;
            color:  #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        .right{
            width: 50%;
            height: 100%;
            position: relative;
        }
        .right .row{
            display: inline-flex;
            margin-bottom: 5%;
            width: 100%;
        }
        .right .row >*{
            width: 100%;
            font-size: 1.5vw;
        }
        .row input{
            border: 1px solid #e3e8e5;
            outline: none;
            padding: 5px;
            border-radius: 5px;
            display: none;
        }
        .row_button{
            display: flex;
            gap: 10px;
        }
        .row_button button{
            cursor: pointer;
            width: 40px;
            border-radius: 10px;
            height: 40px;
            background-color: #30bf58;
            color: #fff;
        }
        .row_button #disabled{
            background-color: #7f8a82;
            cursor: not-allowed;
        }
        .row_button button:hover{
            background-color: #36d662;
        }
        .row_content{
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }
        .update_img{
            position: fixed;
            width: 100%;
            height: 100%;
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            z-index: 10;
            display: none;
        }
        .update_img .form{
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 9;
            width: 30%;
            height: 50%;
            border-radius: 10px;
            transform:  translate(-50%, -50%);
            background-color: #fff;
        }
        .form input{
            border: 1px solid #7f8a82;
        }
        .back{
            display: block;
            text-decoration: none;
            color: #fff;
            width: 10%;
            height: 30px;
            background-color: #30bf58;
            align-content: space-around;
            line-height: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <main>
        <a class="back" href="<?php echo URLROOT ?>">back</a>
        <div class="update_img">
            <div class="form">
                <form action="<?php echo URLROOT; ?>/user/update_avt" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file" id=""><br>
                    <button type="submit">
                        Upload
                    </button>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="left">
                <img src="<?php echo $data->anh; ?>" alt="">
                <button class="show_modal">Update Avatar</button>
            </div>
            <div class="right">
                <div class="row_content">
                    <form action="<?php echo URLROOT ?>/user/update" method="POST">    
                    <input type="hidden" name="id" value="<?php echo $_SESSION['user_id']; ?>">
                    <div class="row">
                        <label>Họ Tên</label>
                        <p> <?php echo $data->name; ?></p>
                        <input type="" name="name" disabled value="<?php echo $data->name ?>" style="background-color: #fff;" id="">
                    </div>
                    <div class="row">
                        <label>Ngày Sinh</label>
                        <p><?php echo $data->ngay_sinh; ?></p>
                        <input type="date" name="date" disabled value="<?php echo $data->ngay_sinh; ?>" style="background-color: #fff;" id="">
                    </div>
                    <div class="row">
                        <label>Địa chỉ</label>
                        <p><?php echo $data->dia_chi; ?></p>
                        <input type="text" name="dia_chi" disabled value="<?php echo $data->dia_chi; ?>" style="background-color: #fff;" id="">
                    </div>
                    <div class="row">
                        <label>Số điện thoại</label>
                        <p><?php echo $data->sdt; ?></p>
                        <input type="text" name="sdt" disabled value="<?php echo $data->sdt; ?>" style="background-color: #fff;" id="">
                    </div>

                    <div class="row row_button">
                        <button>Chỉnh Sửa</button>
                        <button type="submit" disabled id="disabled">Cập Nhật</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="<?php echo URLROOT;?>/public/js/profile.js"> </script>
</body>
</html>