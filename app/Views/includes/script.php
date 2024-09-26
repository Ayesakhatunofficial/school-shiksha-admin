<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- plugins:js -->
<script src="<?= base_url('') ?>public/assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="<?= base_url('') ?>public/assets/vendors/chart.js/Chart.min.js"></script>
<script src="<?= base_url('') ?>public/assets/js/jquery.cookie.js" type="text/javascript"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="<?= base_url('') ?>public/assets/js/off-canvas.js"></script>
<script src="<?= base_url('') ?>public/assets/js/hoverable-collapse.js"></script>
<script src="<?= base_url('') ?>public/assets/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="<?= base_url('') ?>public/assets/js/dashboard.js"></script>
<script src="<?= base_url('') ?>public/assets/js/todolist.js"></script>
<!-- End custom js for this page -->


<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<!-- Include DataTables plugin -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"
  integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8Dof1eAqL2L9" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"
  integrity="sha384-X8PO3e3FSw5AiPf+ckwBLKbOuW2tFezZRMj6Lwx6D7bKFpZ1cEPXmoViHQpXHTPH" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"
  integrity="sha512-W86oCrMn72Nl+wZTyC1qAOnfn3A03hE2I50G3IyyI/aaQh7AAITKrcSDAAxgaa1W/xt2yZWSSaw3IYpjJyqdsA=="
  crossorigin="anonymous"></script>


<script src="https://code.jquery.com/jquery-1.12.3.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.1/dist/js/bootstrap-select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.1/dist/js/bootstrap-select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function () {
    $('.example').DataTable({
      paging: true,
      lengthChange: false,
      pageLength: 20,
      searching: true,
      scrollX: true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        customize: function (xlsx) {
          var sheet = xlsx.xl.worksheets['sheet1.xml'];

          $('row c[r^="C"]', sheet).attr('s', '2');
        }
      }]
    });
    var current = '<?= current_url() ?>';
    var course_view = '<?= base_url('course/view') ?>';
    var course = '<?= base_url('course') ?>';

    var organization_view = '<?= base_url('organization/view') ?>';
    var organization = '<?= base_url('organization') ?>';

    var category_view = '<?= base_url('category/view') ?>';
    var category = '<?= base_url('category') ?>';


    var addstudent = '<?= base_url('student/add') ?>';

    if (current !== course_view && current !== course) {
      $("#course").removeClass("show");
    }

    if (current !== organization_view && current !== organization) {
      $("#organization").removeClass("show");
    }

    if (current !== category_view && current !== category) {
      $("#category").removeClass("show");
    }

    if (current === addstudent) {
      $("#user").removeClass("show");
    }

  });
</script>