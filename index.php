<?php
include "config/connexion.php";
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /monoshop');
}
/* $data = [
    'first_name' => 'tassnim',
    'last_name' => 'mdada',
    'age' => 20,
];
var_dump($data);die;
foreach($data as $key => $field){
    echo $key . ' has value : '.$field ."<br>";
}
die;
$first_name = "tassnim";
$last_name = "mdada"; */
$req = $access->prepare("SELECT * FROM produits ORDER BY id DESC");
$req->execute();
//fetch array of objects(produits)
$produits = $req->fetchAll(PDO::FETCH_OBJ);
//fetch array of array
//$produits = $req->fetchAll(PDO::FETCH_ASSOC);

//var_dump($produits);die;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECommerce</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

</head>

<body>



    <header>
        <div id="menu-bar" class="fas fa-bars"></div>

        <a href="#" class="logo nike">nike</a>
        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#products">products</a>
            <a href="#featured">featured</a>
            <a href="#review">review</a>
        </nav>

        <div class="icons d-flex align-items-center">
            <a href="#" class="fas fa-heart"></a>
            <a href="panier.php" class="fas fa-shopping-cart"></a>
            <?php
            if (isset($_SESSION['id'])) {
                echo '<a href="?logout" class="fa fa-sign-out"></a>';
            } else {
                echo '<a href="login.php" class="fas fa-user"></a>';
            }
            ?>
            <a href="#"><?= isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '' ?></a>
            <?php
            if (isset($_SESSION['id'])) {
                echo '<img src="' . $_SESSION['avatar'] . '" style="width:50px;height:50px;border-radius:50%">';
            }
            ?>
        </div>
    </header>


    <section class="home" id="home">

        <div class="slider-container active">
            <div class="slide">
                <div class="content">
                    <span>nike red shoes </span>
                    <h3>nike metcon shoes</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        In vitae libero nihil odit obcaecati, quidem veniam! Optio minima tenetur repudiandae!</p>
                    <a herf="panier.php" class="btn">add to cart</a>
                </div>
                <div class="image">
                    <img src="images/home-shoe-1.png" class="shoe" alt="">
                    <img src="images/home-text-1.png" class="text" alt="">
                </div>
            </div>
        </div>








        <div class="slider-container">
            <div class="slide">
                <div class="content">
                    <span>nike blue shoes</span>
                    <h3>nike metcon shoes</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        In vitae libero nihil odit obcaecati, quidem veniam! Optio minima tenetur repudiandae!</p>
                    <a herf="#" class="btn">add to cart</a>
                </div>
                <div class="image">
                    <img src="images/home-shoe-2.png" class="shoe" alt="">
                    <img src="images/home-text-2.png" class="text" alt="">
                </div>
            </div>
        </div>


        <div class="slider-container">
            <div class="slide">
                <div class="content">
                    <span>nike yellow shoes</span>
                    <h3>nike metcon shoes</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        In vitae libero nihil odit obcaecati, quidem veniam! Optio minima tenetur repudiandae!</p>
                    <a herf="#" class="btn">add to cart</a>
                </div>
                <div class="image">
                    <img src="images/home-shoe-3.png" class="shoe" alt="">
                    <img src="images/home-text-3.png" class="text" alt="">
                </div>
            </div>
        </div>



        <div id="prev" class="fas fa-chevron-left" onclick="prev ()"></div>
        <div id="next" class="fas fa-chevron-right" onclick="next ()"></div>




    </section>






    <!-- service part  -->

    <section class="service">

        <div class="box-container">


            <div class="box">
                <i class="fas fa-shipping-fast"></i>
                <h3>fast delivery</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Id, tempore?</p>
            </div>


            <div class="box">
                <i class="fas fa-undo"></i>
                <h3>10 days replacements</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Id, tempore?</p>
            </div>


            <div class="box">
                <i class="fas fa-headset"></i>
                <h3>24 x 7 support</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Id, tempore?</p>
            </div>
        </div>
    </section>
    <section class="products" id="products">
        <h1 class="heading">latest <span>products</span></h1>
        <div class="box-container">

        <?php foreach($produits as $produit){ ?>
            <div class="box">
                <div class="icons">
                    <a href="#" class="fas fa-heart"></a>
                    <a href="#" class="fas fa-eye"></a>
                </div>
                <img src="images/<?= $produit->image ?>" alt="">
                <div class="content">
                    <h3 class="name"><?= $produit->nom ?></h3>
                    <div class="price">$<?= $produit->prix ?></div>
                    <?php 
                     if(isset($_SESSION['cart'][$produit->id])){
                         echo '<a class="btn" style="background:lightgray">Déja ajouter</a>';
                     }else{
                         echo '<a href="#" class="btn addToCard" data-id="'. $produit->id .'">Ajouter au panier</a>';
                     }
                     ?>
                    
                </div>
            </div>
        <?php } ?>
        </div>

    </section>




    <section class="featured" id="featured">
        <h1 class="heading"><span>featured</span> products</h1>


        <div class="row">
            <div class="image-container">
                <div class="small-image">
                    <img src="images/f-img-1.1.png" class="featured-image-1" alt="">
                    <img src="images/f-img-1.2.png" class="featured-image-1" alt="">
                    <img src="images/f-img-1.3.png" class="featured-image-1" alt="">
                    <img src="images/f-img-1.4.png" class="featured-image-1" alt="">
                </div>
                <div class="big-image">
                    <img src="images/f-img-1.1.png" class="big-image-1" alt="">
                </div>
            </div>

            <div class="content">
                <h3> new nike airmax shoes</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab autem rem quis quasi,
                    doloribus debitis minima praesentium eligendi voluptates aut.</p>
                <div class="price">$80.99 <span>$120.99</span></div>
                <a href="#" class="btn">add to cart</a>
            </div>
        </div>



        <div class="row">
            <div class="image-container">
                <div class="small-image">
                    <img src="images/f-img-2.1.png" class="featured-image-2" alt="">
                    <img src="images/f-img-2.2.png" class="featured-image-2" alt="">
                    <img src="images/f-img-2.3.png" class="featured-image-2" alt="">
                    <img src="images/f-img-2.4.png" class="featured-image-2" alt="">
                </div>
                <div class="big-image">
                    <img src="images/f-img-2.1.png" class="big-image-2" alt="">
                </div>
            </div>

            <div class="content">
                <h3> new nike airmax shoes</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab autem rem quis quasi,
                    doloribus debitis minima praesentium eligendi voluptates aut.</p>
                <div class="price">$80.99 <span>$120.99</span></div>
                <a href="#" class="btn">add to cart</a>
            </div>
        </div>





        <div class="row">
            <div class="image-container">
                <div class="small-image">
                    <img src="images/f-img-3.1.png" class="featured-image-3" alt="">
                    <img src="images/f-img-3.2.png" class="featured-image-3" alt="">
                    <img src="images/f-img-3.3.png" class="featured-image-3" alt="">
                    <img src="images/f-img-3.4.png" class="featured-image-3" alt="">
                </div>
                <div class="big-image">
                    <img src="images/f-img-3.1.png" class="big-image-3" alt="">
                </div>
            </div>

            <div class="content">
                <h3> new nike airmax shoes</h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab autem rem quis quasi,
                    doloribus debitis minima praesentium eligendi voluptates aut.</p>
                <div class="price">$80.99 <span>$120.99</span></div>
                <a href="#" class="btn">add to cart</a>
            </div>
        </div>

    </section>


    <section class="review" id="review">

        <h1 class="heading">customer's <span>review</span></h1>

        <div class="box-container">

            <div class="box">
                <img src="images/pic1.png" alt="">
                <h3>john deo</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet commodi repellat sequi non, iusto,
                    adipisci ut vero, officia neque totamnecessitatibus porro consectetur reiciendis soluta ipsum tenetur
                    praesentium quis. Quos?</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
            </div>



            <div class="box">
                <img src="images/pic2.png" alt="">
                <h3>john deo</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet commodi repellat sequi non, iusto,
                    adipisci ut vero, officia neque totamnecessitatibus porro consectetur reiciendis soluta ipsum tenetur
                    praesentium quis. Quos?</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
            </div>


            <div class="box">
                <img src="images/pic3.png" alt="">
                <h3>john deo</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet commodi repellat sequi non, iusto,
                    adipisci ut vero, officia neque totamnecessitatibus porro consectetur reiciendis soluta ipsum tenetur
                    praesentium quis. Quos?</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
            </div>
        </div>
    </section>
    <!--footer section-->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>our stores</h3>
                <a href="#">sousse</a>
                <a href="#">tunis</a>
                <a href="#">sfax</a>
                <a href="#">beja</a>
            </div>



            <div class="box">
                <h3>quick links</h3>
                <a href="#home">home</a>
                <a href="#products">products</a>
                <a href="#freatured">featured</a>
                <a href="#review">review</a>
            </div>
            <div class="box">
                <h3>follow us</h3>
                <a href="#">facebook</a>
                <a href="#">twitter</a>
                <a href="#">instagram</a>
                <a href="#">linkedin</a>
            </div>
            <div class="box">
                <h3>extra links</h3>
                <a href="#">my favorite</a>
                <a href="#">my orders</a>
                <a href="aboutus.html">About uS </a>
            </div>
            <div class="box">
                <h3>Payment methods</h3>
                <a href="#">CrediT Card</a>
                <a href="#">PayPal</a>
            </div>
            <div class="box">
                <h3>Easy online shopping</h3>
                <a href="#">Try first, pay after</a>
                <a href="#">Fast delivery, free return</a>
            </div>
        
    

            <div class="credits">created by <span>Mdeda Tesnim</span> | all rights reserved </div>

        </div>

    </section>

    <script src="./main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.addToCard').click(function(){
            let btn = $(this);
            $.ajax({
                url : "ajax_functions.php",
                method : 'POST',
                dataType : 'JSON',
                data : {
                    action : "addToCart",
                    product_id : $(this).data('id'),
                    name : $(this).parent().find('.name').text(),
                    price : $(this).parent().find('.price').text(),
                    image : $(this).closest('.box').find('img').attr('src'),
                },
                success:function(data){
                    if(data.success){
                        Swal.fire({
                            icon : "success",
                            title : data.message,
                        })
                        btn.removeAttr('href');
                        btn.css('background','lightgray');
                        btn.text('Deja ajouter');
                    }else{
                        Swal.fire({
                            icon : "error",
                            title : data.message,
                        })
                    }
                },
                error : function(){
                    Swal.fire({
                            icon : "error",
                            title : "Un erreur est survenue, SVP réessayer plus tard !!",
                        })
                }
            })
        });
    </script>
</body>

</html>