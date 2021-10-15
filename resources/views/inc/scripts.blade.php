{{-- <script src="assets/js/libs/jquery-3.1.1.min.js"></script> --}}
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>

<script>
    $(document).ready(function() {
          App.init();
      });
</script>
<script src="{{asset('assets/js/custom.js')}}"></script>
@yield('js')