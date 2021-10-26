<header>
            <div class="header_row1">
                <ul>
                    <li>
                        <?php
                            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){
                                echo '<a href="'.URLROOT.'/user/profile/'.$_SESSION['user_info']['user_id'].'">'.$_SESSION['user_info']['user_name'].'</a>';
                                echo '<a href="'.URLROOT.'/auth/logout">logout</a>';
                            }
                            else{
                                echo '<a href="'.URLROOT.'/auth/login">Log in</a>';
                            }
                        ?>
                        <ul>
                            <li></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo URLROOT.'/auth/register' ?>">Create an account</a>
                    </li>
                    <li>
                        <a href="#">Cheack out</a>
                    </li>
                </ul>
                <p>Chào mừng đến shop của chúng tôi</p>
            </div>
            <div class="header_row2">
                <img src="img/logo/Camera-N-logos/Camera-N-logos_black.png" alt="">
                <div class="head_row2_right">
                    <div class="search"><input type="text" placeholder="Tìm kiếm"></div>
                    <a class="cart" href="<?php echo URLROOT ?>/product/cart">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <p>Giỏ hàng:</p>
                        <p id="cartNumbers">0</p>
                    </a>
                </div>
            </div>
        
    </header>