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
                  <h4 class="card-title mb-3">Edit Organization Course </h4>
                  <?php echo form_open(base_url('organization/editcourse'), 'class="row needs-validation" method="POST" enctype="multipart/form-data" id="quickForm" novalidate'); ?>
                  <input type="hidden" name="hidden_id" value="<?= $courseOrg['id'] ?? "" ?>">
                  <input type="hidden" name="org_id" value="<?= $courseOrg['organization_id'] ?? "" ?>">

                  <div class="form-group col-lg-6">
                    <label>Course <i class="mdi mdi-star color-danger"></i></label>
                    <select required name="course_id" id="course_id" class="form-control">
                      <option value="">Select</option>
                      <?php foreach ($course as $row) { ?>
                        <option value="<?= $row->id ?>" <?= $row->id == $courseOrg['course_id'] ? "selected" : "" ?>>
                          <?= $row->name; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Course Duration(In Month) </label>
                    <input type="number" class="form-control" id="course_duration" value="<?= $courseOrg['course_duration'] ?? ""; ?>" placeholder="Course Duration" name="course_duration" maxlength="2">
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Course Amount </label>
                    <input type="number" class="form-control" value="<?= $courseOrg['course_fees'] ?? ""; ?>" id="course_fees" placeholder="Course Amount" name="course_fees">
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Last Submission Date </label>
                    <input type="date" class="form-control" id="" placeholder="Last Submission Date" name="last_submission_date" value="<?= $courseOrg['last_submission_date'] ?? ""; ?>">
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Register Through <i class="mdi mdi-star color-danger"></i></label>
                    <select required name="register_through" id="register_through" class="form-control">
                      <option value="">Select</option>
                      <option value="internal_form_submit" <?= $courseOrg['register_through'] == 'internal_form_submit' ? "selected" : ""; ?>>Internal Form Submit</option>
                      <option value="external_link" <?= $courseOrg['register_through'] == 'external_link' ? "selected" : ""; ?>>External link</option>
                    </select>
                  </div>

                  <div class="form-group col-lg-6" id="external_link_field" style="display: none;">
                    <label>External Link <i class="mdi mdi-star color-danger"></i></label>
                    <input required type="url" class="form-control" id="url" placeholder="Enter External link" value="<?= $courseOrg['url'] ?? ""; ?>" name="url">
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Eligibility </label>
                    <input type="text" class="form-control" id="" placeholder="Eligibility" name="eligibility" value="<?= $courseOrg['eligibility'] ?? ""; ?>">
                  </div>

                  <?php
                  $required_field = isset($courseOrg['required_field']) ? json_decode($courseOrg['required_field']) : "";
                  ?>

                  <div class="form-group col-lg-6">
                    <label> Call Me <i class="mdi mdi-star color-danger"></i>
                    </label>
                    <div class="row" style="gap: 6px;margin-left: 10px;">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="call" id="call_yes" value="yes" <?= isset($required_field->is_call_required) && $required_field->is_call_required == 'yes' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="call_yes">Yes</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="call" id="call_no" value="no" <?= isset($required_field->is_call_required) && $required_field->is_call_required == 'no' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="call_no">No</label>
                      </div>
                    </div>

                  </div>

                  <div class="card mt-4 ml-3 mb-3 col-lg-11">
                    <div class="card-header">
                      <label> <b>Extra Data</b></label>
                    </div>

                    <!-- ... Previous HTML code ... -->

                    <div class="card-body " id="TimmingContainer">
                      <?php
                      $extra_data = $courseOrg['extra_data'] ? json_decode($courseOrg['extra_data']) : ['' => ""];
                      $i = 0;
                      foreach ($extra_data as $index => $values) {

                      ?>
                        <div class="Timming-row">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Key :</label>
                                <input type="text" name="keys[]" value="<?= isset($index) ? $index : ''; ?>" class="form-control key" placeholder="Enter your key name">
                              </div>
                            </div>
                            <div class="col-sm-5">
                              <div class="form-group">
                                <label>Value :</label>
                                <input type="text" name="values[]" value="<?= isset($values) ? $values : ''; ?>" class="form-control value" placeholder="Enter your value">
                              </div>
                            </div>
                            <div class="col-md-1">
                              <div class="form-group">
                                <label></label>
                                <div class="row">
                                  <button type="button" class="btn btn-success add-Timming" style="<?php echo $i === 0 ? '' : 'display:none;'; ?>margin-top:0px;">+</button>
                                  <button type="button" class="btn btn-danger remove-Timming" style="<?php echo $i === 0 ? 'display:none;' : ''; ?> margin-top:0px;">-</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php $i++;
                      } ?>
                    </div>
                    <!-- ... Remaining HTML code ... -->
                  </div>
                  <div class="col-lg-12">
                    <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
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
  $(document).ready(function() {


    $('#quickForm').validate({
      rules: {
        course_id: {
          required: true
        },
        // course_fees: {
        //   required: true
        // },
        // course_duration: {
        //   required: true,
        //   maxlength: 2 // Maximum length of 2 digits
        // },
        // last_submission_date: {
        //   required: true,
        //   date: true
        // },
        call: {
          required: true
        },
        register_through: {
          required: true
        },
        url: {
          required: function(element) {
            return $('#register_through').val() === 'external_link';
          },
          url: true
        }
      },
      messages: {
        course_id: {
          required: "Please select a course"
        },
        // course_fees: {
        //   required: "Please enter a course amount"
        // },
        // course_duration: {
        //   required: "Please enter a course duration",
        //   maxlength: "Course duration must not exceed 2 digits"
        // },
        // last_submission_date: {
        //   required: "Please enter last submission date",
        //   date: "Please enter a valid date"
        // },
        call: {
          required: "Call me field is required"
        },
        register_through: {
          required: "Please select a registration method"
        },
        url: {
          required: "Please enter an external link",
          url: "Please enter a valid URL"
        }
      },
      errorClass: "error-text",
      errorElement: "span",
      submitHandler: function(form) {
        // Optionally, perform additional client-side validation here
        console.log("Form submitted successfully!"); // Check if this message appears in the console
        form.submit(); // Submit the form if all validations pass
      }
    });

    // Function to toggle the display of the external link field based on selection
    function toggleExternalLinkField() {
      var selectedValue = $('#register_through').val();
      if (selectedValue === 'external_link') {
        $('#external_link_field').show();
        $('#url').attr('required', true);
      } else {
        $('#external_link_field').hide();
        $('#url').removeAttr('required');
      }
    }

    // Initial check based on the pre-selected value
    toggleExternalLinkField();

    // Change event handler
    $('#register_through').change(function() {
      toggleExternalLinkField();
    });

    // Handle addition of Timming rows
    $("#TimmingContainer").on("click", ".add-Timming", function() {
      var newTimmingRow = $(".Timming-row:first").clone(true);
      newTimmingRow.find("input").val('');
      newTimmingRow.find('.add-Timming').hide();
      newTimmingRow.find('.remove-Timming').show();
      $("#TimmingContainer").append(newTimmingRow);
    });

    // Remove Timming row
    $("#TimmingContainer").on("click", ".remove-Timming", function() {
      $(this).closest(".Timming-row").remove();
    });
  });
</script>