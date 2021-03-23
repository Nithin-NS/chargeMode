<!-- Core  -->
<script src="{{ asset('/assets/vendor/babel-external-helpers/babel-external-helpers.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/jquery/jquery.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/popper-js/umd/popper.min.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/bootstrap/bootstrap.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/animsition/animsition.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/mousewheel/jquery.mousewheel.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/asscrollbar/jquery-asScrollbar.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/asscrollable/jquery-asScrollable.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/ashoverscroll/jquery-asHoverScroll.js', config('app.asset_secure')) }}"></script>

<!-- Plugins -->
<script src="{{ asset('/assets/vendor/switchery/switchery.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/intro-js/intro.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/screenfull/screenfull.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/slidepanel/jquery-slidePanel.js', config('app.asset_secure')) }}"></script>

<script src="{{ asset('/assets/vendor/datatables.net/jquery.dataTables.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-bs4/dataTables.bootstrap4.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-rowgroup/dataTables.rowGroup.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-scroller/dataTables.scroller.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-responsive/dataTables.responsive.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-buttons/dataTables.buttons.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-buttons/buttons.html5.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-buttons/buttons.flash.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-buttons/buttons.print.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-buttons/buttons.colVis.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js', config('app.asset_secure')) }}"></script>

<script src="{{ asset('/assets/vendor/asrange/jquery-asRange.min.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/bootbox/bootbox.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/toastr/toastr.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/jquery-validation/jquery.validate.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/jquery-validation/additional-methods.min.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/select2/select2.full.min.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/ladda/spin.min.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/ladda/ladda.min.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/alertify/alertify.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js', config('app.asset_secure')) }}"></script>
@stack('js_vendor')

        <!-- Scripts -->
<script src="{{ asset('/assets/js/Component.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Plugin.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Base.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Config.js', config('app.asset_secure')) }}"></script>

<script src="{{ asset('/assets/js/Section/Menubar.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Section/GridMenu.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Section/Sidebar.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Section/PageAside.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Plugin/menu.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Plugin/datatables.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Plugin/toastr.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Plugin/select2.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Plugin/ladda.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Plugin/alertify.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Plugin/bootstrap-datepicker.js', config('app.asset_secure')) }}"></script>

<script src="{{ asset('/assets/js/config/colors.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/config/tour.js', config('app.asset_secure')) }}"></script>
<script>Config.set('assets', 'assets');</script>

<!-- Page -->
<script src="{{ asset('/assets/js/Site.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Plugin/asscrollable.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Plugin/slidepanel.js', config('app.asset_secure')) }}"></script>
<script src="{{ asset('/assets/js/Plugin/switchery.js', config('app.asset_secure')) }}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap"></script>
@stack('js')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.extend(true, $.fn.dataTable.defaults, {
        language: {
            info: '&nbsp;_START_ - _END_ of _TOTAL_',
            lengthMenu: 'Rows per page _MENU_&nbsp;',
            searchPlaceholder: 'Search..',
            search: '_INPUT_' // ,paginate: {
            //   previous: '<i class="icon wb-chevron-left-mini"></i>',
            //   next: '<i class="icon wb-chevron-right-mini"></i>'
            // }
            // ,
            // classes: {
            //   sFilterInput: "form-control form-control-sm",
            //   sLengthSelect: "form-control form-control-sm"
            // }

        }
    });
    $.fn.datepicker.defaults.format = "M dd, yyyy";

    jQuery.validator.setDefaults({
        debug: false,
        validClass: "is-valid",
        errorClass: "is-invalid",
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');

            if($(element).parent().is('.dropify-wrapper')) {
                error.insertAfter($(element).parent());
            } else if($(element).parent().is('.input-group')) {
                error.insertAfter($(element).parent());
            } else if($(element).parent().is('.intl-tel-input')) {
                error.insertAfter($(element).parent());
            } else if($(element).parent().is('.validator-group')) {
                error.insertAfter($(element).parent());
            } else {
                error.appendTo($(element).parent());
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
            $(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
            $(element).closest('.form-group').removeClass(errorClass).addClass(validClass);
        }
    });

    (function (document, window, $) {
        'use strict';

        var Site = window.Site;
        $(document).ready(function () {
            Site.run();
        });

        $(document).on('draw.dt', function (e) {
            Site.getInstance().initializePlugins(e.target);
            $(e.target).find('[data-toggle="tooltip"]').tooltip();
        });

        $(document).ajaxSuccess(function(event, jqxhr, settings) {
            console.log(jqxhr);
            console.log(settings);

            var responseJSON = jqxhr.responseJSON;

            if (!responseJSON) {
                responseJSON = $.parseJSON(responseText);
            }

            if (responseJSON.success) {
                toastr.success(responseJSON.success);
            }

            if (responseJSON.message) {
                toastr.success(responseJSON.message);
            }

            if (responseJSON.info) {
                toastr.info(responseJSON.info);
            }

            if (responseJSON.warning) {
                toastr.warning(responseJSON.warning);
            }

            if (responseJSON.error) {
                toastr.error(responseJSON.error);
            }
        });

        $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
            console.log(jqxhr);

            var responseJSON = jqxhr.responseJSON;

            if (!responseJSON) {
                responseJSON = $.parseJSON(responseText);
            }

            if (jqxhr.status == 419) {
                location.reload();
            }

            if (responseJSON.message) {
                toastr.error(responseJSON.message);
            }
        });

    })(document, window, jQuery);
</script>

<script>
    (function (document, window, $) {
        'use strict';

        <?php
        $alerts = ['success', 'info', 'warning', 'error'];
        ?>

        @foreach($alerts as $alert)
            @if(session()->has($alert))
                toastr['{{ $alert }}']('{{ session()->get($alert) }}');
            @endif
        @endforeach

        <?php
        session()->forget($alerts);
        ?>

    })(document, window, jQuery);
</script>
@stack('scripts')
