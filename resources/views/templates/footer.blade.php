  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrapku/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/fontawesome/js/all.js') }}"></script>
  <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>

  <!-- Page level plugins -->
  <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  {{-- Sweetalert --}}

  {{-- Success --}}
  @if (session('message'))
      <script>
          Swal.fire({
              position: "top-end",
              title: "{{ session('message') }}",
              icon: "{{ session('type-message') }}",
              showConfirmButton: false,
              toast: true,
              timer: 2500,
          });
      </script>
  @endif

  {{-- Error --}}
  @if ($errors->any())
      <script>
          Swal.fire({
              position: "top-end",
              title: "An error occurred, please try again!",
              icon: "error",
              toast: true,
              showConfirmButton: false,
              timer: 2500,
          });
      </script>
  @endif

  {{-- Delete --}}
  @if (session('message_delete'))
      <script>
          Swal.fire({
              position: "top-end",
              title: "{{ session('message_delete') }}",
              icon: "{{ session('type-message') }}",
              showConfirmButton: false,
              toast: true,
              timer: 2500,
          });
      </script>
  @endif

  {{-- confirm deletion --}}
  <script>
      function confirmDelete(id) {
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to return them!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Delete'
          }).then((result) => {
              if (result.isConfirmed) {
                  document.getElementById('delete-form-' + id).submit();
              }
          });
      }
  </script>

  {{-- Confirm Inactive --}}
  <script>
      function confirmInactive(id) {
          Swal.fire({
              title: 'Are you sure?',
              text: "Your account will be deactivated",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Inactive'
          }).then((result) => {
              if (result.isConfirmed) {
                  document.getElementById('inactive-form-' + id).submit();
              }
          });
      }
  </script>

  </body>

  </html>
