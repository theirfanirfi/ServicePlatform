

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->

    <script src="{{asset('js/jquery.min.js')}}"></script>
    {{--<script src="{{asset('js/jquery.min.js')}}"></script>--}}
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    {{--<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>--}}
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    {{--<script src="{{asset('js/bootstrap.min.js')}}"></script>--}}
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
    <script>moment.tz.setDefault('America/Monterrey');</script>
    {{--<script src="{{ asset('js/select2.full.min.js') }}"></script>--}}
    @stack('after_scripts')

  </body>

</html>
