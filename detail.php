<?php
include 'header.php';
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = mysqli_query($conn, "SELECT*FROM product WHERE id = $id");
	$product = mysqli_fetch_object($query);
	$prod_relate = mysqli_query($conn, "SELECT*FROM product WHERE category_id = $product->category_id ORDER BY rand() LIMIT 4");
}
?>
<style>
	.img-fluid1{
		height: 180px
	}
</style>
<div class="hero-wrap hero-bread" style="background-image: url('src/images/bg_1.jpg');">
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ</a></span> <span class="mr-2"><a href="shop.php">Product</a></span> <span>Chi tiết sản phẩm</span></p>
				<h1 class="mb-0 bread">Chi tiết sản phẩm</h1>
			</div>
		</div>
	</div>
</div>

<section class="ftco-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mb-5 ftco-animate">
				<a href="images/product-1.jpg" class="image-popup"><img src="admin/assets/images/<?= $product->image ?>" class="img-fluid" alt="Colorlib Template"></a>
			</div>
			<div class="col-lg-6 product-details pl-md-5 ftco-animate">
				<h3><?= $product->name ?></h3>
				<div class="rating d-flex">
					<p class="text-left mr-4">
						<a href="#" class="mr-2">5.0</a>
						<a href="#"><span class="ion-ios-star-outline"></span></a>
						<a href="#"><span class="ion-ios-star-outline"></span></a>
						<a href="#"><span class="ion-ios-star-outline"></span></a>
						<a href="#"><span class="ion-ios-star-outline"></span></a>
						<a href="#"><span class="ion-ios-star-outline"></span></a>
					</p>
					<p class="text-left mr-4">
						<a href="#" class="mr-2" style="color: #000;">100 <span style="color: #bbb;">Rating</span></a>
					</p>
					<p class="text-left">
						<a href="#" class="mr-2" style="color: #000;">500 <span style="color: #bbb;">Sold</span></a>
					</p>
				</div>
				<?php if (($product->sale_price) > 0) { ?>
					<p class="price text-success">Giá khuyến mãi : <?=number_format($product->sale_price);?> vnđ</p>
				<?php } else { ?>
					<p>Giá : <span><?= number_format($product->price) ?></span> vnđ</p>
				<?php } ?>
				<p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until.
				</p>
				<div class="row mt-4">
					<div class="input-group col-md-6 d-flex mb-3">
						<form action="cart-process.php" class="form-inline">
							<input type="hidden" name="id" class="form-control input-number" value="<?=$product->id?>">
							<label for="quantity">Quantity</label>
							<input type="text" id="quantity" name="quantity" class="form-control input-number mb-2" value="1">
							<input type="hidden" name="action" class="form-control input-number" value="add">
							<button class="btn btn-add">Add to Cart</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center mb-3 pb-3">
			<div class="col-md-12 heading-section text-center">
				<span class="subheading">Sản phẩm</span>
				<h2 class="mb-4">Sản phẩm liên quan</h2>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<?php while($item = mysqli_fetch_object($prod_relate)) { ?>
				<div class="col-md-6 col-lg-3 ftco-animate">
					<div class="product">
						<a href="#" class="img-prod"><img class="img-fluid1" src="admin/assets/images/<?=$item->image;?>" alt="Colorlib Template">
							<div class="overlay"></div>
						</a>
						<div class="text py-3 pb-4 px-3 text-center">
							<h3><a href="#"><?=$item->name;?></a></h3>
							<div class="d-flex">
								<div class="pricing">
									<?php if ($item->sale_price > 0) { ?>
										<p class="price">Giá khuyến mãi : <?= number_format($item->sale_price); ?> vnđ</p>
									<?php } else { ?>
										<p>Giá : <span><?= number_format($item->price); ?> vnđ</span>
									<?php } ?>
								</div>
							</div>
							<div class="bottom-area d-flex px-3">
								<div class="m-auto d-flex">
									<a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
										<span><i class="ion-ios-menu"></i></span>
									</a>
									<a href="cart-process.php?id=<?=$product->id?>" class="buy-now d-flex justify-content-center align-items-center mx-1 add-cart">
										<span><i class="ion-ios-cart"></i></span>
									</a>
									<a href="#" class="heart d-flex justify-content-center align-items-center ">
										<span><i class="ion-ios-heart"></i></span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>

<?php include 'footer.php'; ?>
<script>
	$(document).ready(function(){
		$(document).on('click', '.btn-add',function(e){
			e.preventDefault();
			var data = $(this).closest('form').serialize();
			$.ajax({
				url : "cart-process.php?" + data,
				type : "GET",
				success : function(res){
					Swal.fire({
                            html: res.message,
                            icon: res.icon
                        });
                    $(".cta-colored").load(location.href + " .cta-colored>*");
				}
			})
		});

		$(document).on('click','.add-cart',function(e){
			e.preventDefault();
			var href = $(this).attr('href');
			$.ajax({
                url : href,
                type : "GET",
                success : function(res){
                    console.log(res);
                    if(res.status==true){
                        Swal.fire({
                            html: res.message,
                            icon: res.icon
                        });
                        $(".cta-colored").load(location.href + " .cta-colored>*");
                    }
                }
            });
		});
	});
</script>