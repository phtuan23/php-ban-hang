<?php include 'layout/header.php'; ?>
<?php include 'layout/navbar.php'; ?>

<?php 
    $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
    $total = mysqli_num_rows($orders); // tính tổng số bản ghi
    $limit = 4; // số bản ghi trên 1 trang.
    $total_page = ceil($total / $limit); // tỉnh tổng số trang.
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // lấy ra trang hiện tại
    $start = ($current_page - 1) * $limit; // bản ghi bắt đầu ở trang hiện tại
    $orders = mysqli_query($conn, "SELECT * FROM orders order by id desc LIMIT $start,$limit");

    if(isset($_GET['search'])){
        $search = $_GET['search'];
        $orders = mysqli_query($conn, "SELECT * FROM orders WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'");
        $total = mysqli_num_rows($orders);
        $limit = 4; // số bản ghi trên 1 trang.
        $total_page = ceil($total / $limit); // tỉnh tổng số trang.
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // lấy ra trang hiện tại
        $start = ($current_page - 1) * $limit; // bản ghi bắt đầu ở trang hiện tại
        $orders = mysqli_query($conn, "SELECT * FROM orders WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' LIMIT $start,$limit");
    }

    if(isset($_GET['status'])){
        $status = $_GET['status'];
        $orders = mysqli_query($conn, "SELECT * FROM orders WHERE status = $status");
        $total = mysqli_num_rows($orders);
        $limit = 4; // số bản ghi trên 1 trang.
        $total_page = ceil($total / $limit); // tỉnh tổng số trang.
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // lấy ra trang hiện tại
        $start = ($current_page - 1) * $limit; // bản ghi bắt đầu ở trang hiện tại
        $orders = mysqli_query($conn, "SELECT * FROM orders WHERE status = $status LIMIT $start,$limit");
    }
?>
<div class="pcoded-content" id="main-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Quản lý đơn đặt</h5>
                        <p class="m-b-0">Danh sách đơn đặt</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Danh sách đơn đặt</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">
                    <!-- Basic table card start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Danh sách đơn đặt hàng</h5>
                            <div class="p-15 ">
                                <form class="form-material" id="form-search">
                                    <div class="form-group form-primary">
                                        <input type="text" name="search" id="search" class="form-control" width="300px">
                                        <label class="float-label"><i class="fa fa-search m-r-10"></i>Tìm kiếm</label>
                                    </div>
                                    <a href="order.php" class="btn btn-sm btn-info status">Tất cả</a>
                                    <a href="order.php?status=0" class="btn btn-sm btn-success status">Đã đặt</a>
                                    <a href="order.php?status=1" class="btn btn-sm btn-secondary status">Đã giao hàng</a>
                                    <a href="order.php?status=2" class="btn btn-sm btn-danger status">Đã hủy</a>
                                </form>
                            </div>
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                    <li><i class="fa fa-trash close-card"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            <div class="table-responsive" id="table_data">
                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="font-weight-bold">#</th>
                                            <th class="font-weight-bold">Khách hàng</th>
                                            <th class="font-weight-bold">Email</th>
                                            <th class="font-weight-bold">Phone</th>
                                            <th class="font-weight-bold">Status</th>
                                            <th class="font-weight-bold"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($orders as $order) {?>
                                            <tr class="text-center">
                                                <td><?= $order['id']; ?></td>
                                                <td><?= $order['name']; ?></td>
                                                <td><?= $order['email']; ?></td>
                                                <td><?= $order['phone']; ?></td>
                                                <td>
                                                    <?php if($order['status']==0){ ?>
                                                        <span class="badge badge-success">Đã đặt</span>
                                                    <?php }else if($order['status']==1){ ?>
                                                        <span class="badge badge-secondary">Đã giao hàng</span>
                                                    <?php }else{ ?>
                                                        <span class="badge badge-danger">Đã hủy</span>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <hr>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php if(isset($_GET['search'])){ ?>
                                            <li class="page-item <?= ($current_page == 1) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="order.php?search=<?=$_GET['search']?>&page=<?= $current_page - 1 ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                            <li class="page-item <?= ($current_page == $i) ? 'active' : '' ?>"><a class="page-link" href="order.php?search=<?=$_GET['search']?>&page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php } ?>
                                            <li class="page-item <?= ($current_page == $total_page) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="order.php?search=<?=$_GET['search']?>&page=<?= $current_page + 1 ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        <?php }else if(isset($_GET['status'])){ ?>
                                        <li class="page-item <?= ($current_page == 1) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="order.php?status=<?=$_GET['status']?>&page=<?= $current_page - 1 ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                            <li class="page-item <?= ($current_page == $i) ? 'active' : '' ?>"><a class="page-link" href="order.php?status=<?=$_GET['status']?>&page=<?= $i ?>"><?= $i ?></a></li>
                                        <?php } ?>
                                        <li class="page-item <?= ($current_page == $total_page) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="order.php?status=<?=$_GET['status']?>&page=<?= $current_page + 1 ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                        <?php }else{?>
                                            <li class="page-item <?= ($current_page == 1) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="order.php?page=<?= $current_page - 1 ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                        <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                                <li class="page-item <?= ($current_page == $i) ? 'active' : '' ?>"><a class="page-link" href="order.php?page=<?= $i ?>"><?= $i ?></a></li>
                                        <?php } ?>
                                            <li class="page-item <?= ($current_page == $total_page) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="order.php?page=<?= $current_page + 1 ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-body end -->
            </div>
        </div>
        <!-- Main-body end -->
    </div>
<?php include 'layout/footer.php'; ?>
<script>
    $(document).on('click', 'a.page-link', function(e) {
        e.preventDefault();
        var href = $(this).attr("href");
        $.ajax({
            url: href,
            type: "GET",
            success: function() {
                $("#table_data").load(href + " #table_data>*");
                $("html, body").animate({scrollTop: 250}, 500);
            }
        });
    });

    $(document).on('keyup','#search',function(e){
        e.preventDefault();
        var search = $(this).val();
        var url = '';
        if(search!=''){
            url = "order.php?search=" + search;
        }else{
            url = "order.php";
        }
        $.ajax({
            url : url,
            type : "GET",
            success : function(res){
                $("#table_data").load(url + " #table_data>*");
            }
        });
    });

    $(document).on('click','.status',function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        $.ajax({
            url : href,
            type : 'GET',
            success : function(res){
                $("#table_data").load(href + " #table_data>*");
            }
        })
    })
</script>