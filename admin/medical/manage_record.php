<?php
require_once('../../config.php');

$id = '';
$pet_name = '';
$client_name = '';
$medical_condition = '';
$proposed_solution = '';
$date_of_record = '';
$delete_flag = 0;

if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `medicalrecords` WHERE record_id = '{$_GET['id']}'");
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
    <form action="" id="record-form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="pet_name" class="control-label">Pet Name</label>
            <input type="text" name="pet_name" id="pet_name" class="form-control form-control-border"
                placeholder="Enter Pet Name" value="<?php echo isset($pet_name) ? $pet_name : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="client_name" class="control-label">Client Name</label>
            <input type="text" name="client_name" id="client_name" class="form-control form-control-border"
                placeholder="Enter Client Name" value="<?php echo isset($client_name) ? $client_name : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="medical_condition" class="control-label">Medical Condition</label>
            <textarea name="medical_condition" id="medical_condition" class="form-control form-control-border"
                placeholder="Enter Medical Condition" required><?php echo isset($medical_condition) ? $medical_condition : '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="proposed_solution" class="control-label">Proposed Solution</label>
            <textarea name="proposed_solution" id="proposed_solution" class="form-control form-control-border"
                placeholder="Enter Proposed Solution"><?php echo isset($proposed_solution) ? $proposed_solution : '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="date_of_record" class="control-label">Date of Record</label>
            <input type="text" name="date_of_record" id="date_of_record" class="form-control form-control-border"
                value="<?php echo isset($date_of_record) ? $date_of_record : date("Y-m-d H:i:s") ?>" disabled>
        </div>
        <div class="form-group" hidden>
            <label for="delete_flag" class="control-label">Delete Flag</label>
            <input type="checkbox" name="delete_flag" id="delete_flag" class="form-control form-control-border"
                <?php echo ($delete_flag) ? 'checked' : ''; ?>>
        </div>
    </form>
</div>

<script>
    $(function () {
        $('#uni_modal #record-form').submit(function (e) {
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>');
            el.addClass("pop-msg alert");
            el.hide();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_medical_record", // Update URL to match save_medical_record
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
                    } else {
                        alert_toast("Error: " + resp.msg, 'error');
                        end_loader();
                    }
                    el.show('slow');
                    $('html,body,.modal').animate({ scrollTop: 0 }, 'fast');
                }
            });
        });
    });
</script>
