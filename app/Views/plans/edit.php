<!DOCTYPE html>
<html lang="en">

<?= view('includes/head.php') ?>

<body>

  <div class="container-scroller">

    <?= view('includes/header.php') ?>

    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->

      <?= view('includes/sidebar.php') ?>

      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-3">Edit Plans</h4>
                  <!-- <p class="card-description"> Basic form elements </p> -->
                  <?php echo form_open(base_url('editplans'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                  <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" placeholder="" value="<?= $plans['id'] ?>">

                  <div class="form-group col-lg-6">
                    <label>User Roles <i class="mdi mdi-star color-danger"></i></label>
                    <select required name="role_id" id="role_id" class="form-control" disabled>
                      <option value="">Select</option>
                      <?php foreach ($roles as $row) { ?>
                        <option value="<?= $row['id'] ?>" <?= $plans['role_id'] == $row['id'] ? "selected" : "" ?>>
                          <?= ucwords(str_replace('_', ' ', $row['role_name'])) ?>
                        </option>

                      <?php } ?>
                    </select>
                  </div>


                  <div class="form-group col-lg-6">
                    <label>Plan Name <i class="mdi mdi-star color-danger"></i></label>
                    <input required type="text" value="<?= $plans['plan_name'] ?>" class="form-control" id="plan_name" placeholder="Plan Name" name="plan_name">
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Plan Amount <i class="mdi mdi-star color-danger"></i></label>
                    <input required type="number" value="<?= $plans['plan_amount'] ?>" class="form-control" id="plan_amount" placeholder="Plan Name" name="plan_amount">
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="plan_duration">Plan Duration <i class="mdi mdi-star color-danger"></i></label>
                    <select required name="plan_duration" id="" class="form-control">
                      <option value="1" <?= $plans['plan_duration'] == '1' ? "selected" : "" ?>>One Month</option>
                      <option value="3" <?= $plans['plan_duration'] == '3' ? "selected" : "" ?>>Three Months</option>
                      <option value="6" <?= $plans['plan_duration'] == '6' ? "selected" : "" ?>>Six Months</option>
                      <option value="12" <?= $plans['plan_duration'] == '12' ? "selected" : "" ?>>Twelve Month</option>
                      <option value="24" <?= $plans['plan_duration'] == '24' ? "selected" : "" ?>>Twenty four Months</option>
                      <option value="36" <?= $plans['plan_duration'] == '36' ? "selected" : "" ?>>Thirty six months</option>
                      <option value="48" <?= $plans['plan_duration'] == '48' ? "selected" : "" ?>>Forty Eight Months</option>
                      <option value="60" <?= $plans['plan_duration'] == '60' ? "selected" : "" ?>>Sixty Months</option>
                    </select>
                  </div>


                  <div class="form-group col-lg-6" id="service_list">
                    <label>Service Name<i class="mdi mdi-star color-danger"></i></label>
                    <select required multiple class="select2 form-control" data-live-search="true" id="service_id" name='service_id[]'>
                      <?php foreach ($service as $services) { ?>
                        <option value="<?= $services->id ?>" <?= in_array($services->id, array_column($plan_service, 'service_id')) ? "selected" : ""; ?>>
                          <?= isset($services->service_name) ? $services->service_name : ""; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="exampleSelectStatus">Status</label>
                    <select class="form-control" id="exampleSelectStatus" name="is_active">
                      <option value="1" <?= $plans['is_active'] == "1" ? "selected" : "" ?>>Active</option>
                      <option value="0" <?= $plans['is_active'] == "0" ? "selected" : "" ?>>Inactive</option>
                    </select>
                  </div>


                  <div id="addRowContainer" class="form-group col-lg-12" style="text-align: right;">
                    <button type="button" class="btn btn-success add-TodaysDate">Add Row</button>
                  </div>

                  <div class="col-lg-12">
                    <div class="form-group col-lg-12" style="background-color: #b66dff;">
                      <div class="card-header text-center">
                        <label>Plan Description</label>
                      </div>
                    </div>
                  </div>

                  <?php
                  $plan_description = $plans['plan_description'] ? json_decode($plans['plan_description']) : [];
                  // Always display one input field initially, even if $plan_description is empty
                  ?>
                  <div class="form-group col-lg-12 TodaysDateContainer">
                    <div class="input-group">
                      <input type="text" class="form-control plan-description" value="<?= !empty($plan_description) ? $plan_description[0] : '' ?>" placeholder="Plan Description" name="plan_description[]">
                      <!-- Don't add remove button initially -->
                    </div>
                  </div>

                  <?php
                  // If $plan_description is not empty, display additional input fields
                  if (!empty($plan_description)) {
                    for ($i = 1; $i < count($plan_description); $i++) {
                  ?>
                      <div class="form-group col-lg-12 TodaysDateContainer">
                        <div class="input-group">
                          <input type="text" class="form-control plan-description" value="<?= $plan_description[$i] ?>" placeholder="Plan Description" name="plan_description[]">
                          <div class="input-group-append">
                            <!-- Add remove button only for cloned input fields -->
                            <button type="button" class="btn btn-danger remove-TodaysDate">-</button>
                          </div>
                        </div>
                      </div>
                  <?php
                    }
                  }
                  ?>

                  <div id="commid" class="col-lg-12">
                    <div class="form-group col-lg-12" style="background-color: #b66dff;">
                      <div class="card-header" style="text-align: center;">
                        <label>Plan Commission</label>
                      </div>
                    </div>


                    <div class="form-group row">
                      <div class="col-sm-6">
                        <label>Users <i class="mdi mdi-star color-danger"></i></label>
                        <select required name="commission_role_id" id="commission_role_id" class="form-control">
                          <option value="<?= $comision['role_id'] ?? "" ?>">
                            <?php
                            // Find the corresponding role name based on the role_id in $comision
                            $role_name = '';
                            if (!empty($comision)) {
                              foreach ($roles as $role) {
                                if ($role['id'] == $comision['role_id']) {
                                  $role_name = $role['role_name'];
                                  break;
                                }
                              }
                            }
                            echo $role_name = ucwords(str_replace('_', ' ', $role_name))
                            ?>
                          </option>
                        </select>
                      </div>

                      <div class="col-sm-6">
                        <label class="form-label">Commission Amount <i class="mdi mdi-star color-danger"></i></label>
                        <input required type="number" name="amount" id='amount_id' value="<?= $comision['amount'] ?? "" ?>" class="form-control" placeholder="Enter Commission Amount">
                      </div>
                    </div>
                  </div>

                  <div class=" col-lg-12">
                    <button type="submit" class="btn btn-gradient-primary mr-2">Update</button>
                    <a class="btn btn-light" href="<?= base_url('dashboard') ?>">Cancel</a>
                  </div>

                  <?php echo form_close(); ?>
                </div>
              </div>
            </div>
          </div>

        </div>

        <?= view('includes/footer.php') ?>

      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <?= view('includes/script.php') ?>

</body>

</html>

<script>
  $('.select2').select2({
    placeholder: "Select Services", // Placeholder text
    allowClear: true // Allow the user to clear the selection
  });
</script>

<script>
  $(document).ready(function() {
    $('#quickForm').validate({
      rules: {
        role_id: {
          required: true
        },
        plan_name: {
          required: true
        },
        plan_amount: {
          required: true,
          number: true
        },
        service_id: {
          required: true,
        },
        plan_duration: {
          required: true,
          digits: true,
          min: 1
        },
        commission_role_id: {
          required: true
        },
        amount: {
          required: true
        },
      },
      messages: {
        role_id: {
          required: "Please select user role"
        },
        plan_name: {
          required: "Please enter plan name"
        },
        plan_amount: {
          required: "Please enter plan amount",
          number: "Please enter valid number for plan amount"
        },
        plan_duration: {
          required: "Please select plan duration",
          digits: "Please enter only digits (no decimals)",
          min: "Plan duration must be at least 1 month"
        },
        commission_role_id: {
          required: "Please select user role"
        },
        amount: {
          required: "Please enter Commission Amount"
        },
      },
      errorClass: "error-text",
      errorElement: "span",
      submitHandler: function(form) {
        // Optionally, perform additional client-side validation here
        console.log("Form submitted successfully!"); // Check if this message appears in the console
        form.submit(); // Submit the form if all validations pass
      }
    });

    $('.add-TodaysDate').click(function() {
      // Clone the row
      var newRow = $('.TodaysDateContainer').first().clone();
      // Clear input value
      newRow.find('.plan-description').val('');
      // Append the remove button to the cloned row
      newRow.find('.input-group').append('<div class="input-group-append"><button type="button" class="btn btn-danger remove-TodaysDate">-</button></div>');
      // Append the cloned row after the last row
      $('.TodaysDateContainer:last').after(newRow);
      // Add remove button click event for cloned row
      newRow.find('.remove-TodaysDate').click(function() {
        $(this).closest('.TodaysDateContainer').remove();
      });
    });

    // Remove button click event for existing cloned rows
    $(document).on('click', '.remove-TodaysDate', function() {
      // Remove the current row
      $(this).closest('.TodaysDateContainer').remove();
    });


    $('#role_id').change(function() {
      var roleId = $(this).val();
      console.log(roleId);
      $.ajax({
        url: '<?= base_url('plan/fetchUser') ?>',
        method: 'POST',
        data: {
          role_id: roleId
        },
        success: function(response) {
          $('#commission_role_id').html(response);
        },
        error: function(xhr, status, error) {
          console.error('AJAX request failed');
          console.error(xhr.responseText);
        }
      });

      if (roleId == 2) {
        $('#commid').hide();
      } else {
        $('#commid').show();
      }
    });
  });

  window.addEventListener("load", (event) => {
    var role_id = document.getElementById("role_id").value;

    if (role_id == 5) {
      $('#service_list').show();
    } else {
      $('#service_list').hide();
    }
  });

  window.onload = function() {
    var role_id = document.getElementById("role_id").value;

    if (role_id == 2) {
      $('#commid').hide();
    } else {
      $('#commid').show();
    }
  };
</script>