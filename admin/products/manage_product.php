<?php
require_once('../../config.php');

$id = '';
$name = '';
$price = '';
$stocks = '';
$description = '';

if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `products` WHERE id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k)) {
                $$k = $v;
            }
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="product-form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="name" class="control-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control form-control-border"
                placeholder="Enter Product Name" value="<?php echo isset($name) ? $name : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="price" class="control-label">Price</label>
            <input type="text" name="price" id="price" class="form-control form-control-border"
                placeholder="Enter Price" value="<?php echo isset($price) ? $price : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="stocks" class="control-label">Stocks</label>
            <input type="number" name="stocks" id="stocks" class="form-control form-control-border"
                placeholder="Enter Stocks" value="<?php echo isset($stocks) ? $stocks : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Description</label>
            <textarea name="description" id="description" class="form-control form-control-border"
                placeholder="Enter Description"
                required><?php echo isset($description) ? $description : '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="image" class="control-label">Product Image</label>
            <input type="file" name="image" id="image" class="form-control form-control-border" accept="image/*">
        </div>
    </form>
</div>

<script>
    $(function () {
        $('#uni_modal #product-form').submit(function (e) {
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>');
            el.addClass("pop-msg alert");
            el.hide();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_product", // Update URL to match save_product
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("Success", 'success');
                    end_loader();
                },
                success: function (resp) {
                    if (resp.status == 'success') {
                        location.reload();
                    } else if (!!resp.msg) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                    el.show('slow');
                    $('html,body,.modal').animate({ scrollTop: 0 }, 'fast');
                    end_loader();
                }
            });
        });
    });
</script>