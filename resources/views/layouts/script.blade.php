<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<script src="assets/vendors/chart.js/chart.umd.js"></script>
<script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="assets/js/off-canvas.js"></script>
<script src="assets/js/hoverable-collapse.js"></script>
<script src="assets/vendors/js/maxcdn.min.js"></script>
<script src="assets/js/template.js"></script>
<script src="assets/js/settings.js"></script>
<script src="assets/js/todolist.js"></script>
<script src="assets/js/dashboard.js"></script>
<script src="assets/js/proBanner.js"></script>
<script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="
https://cdn.jsdelivr.net/npm/jquery.repeater@1.2.1/jquery.repeater.min.js
"></script>
<script>
  $('.repeater').repeater({
    defaultValues: {
      'text-input': 'foo'
    },
    show: function () {
      $(this).slideDown();
    },
    hide: function (deleteElement) {
      $(this).slideUp(deleteElement);
    },
    isFirstItemUndeletable: true
  });
</script>