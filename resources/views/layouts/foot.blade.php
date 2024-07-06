		<script>
			window.Laravel = {!! json_encode([
				'csrfToken'	   	   => csrf_token(),
				'baseUrl' 	   	   => url('/'),
				'userData' 	   	   => Auth::user(),
				// 'actual_route' 	   => $actual_route,
				'errors'       	   => $errors->all(),
				'user_roles'   	   => (Auth::check()) ? Auth::user()->getRoleNames() : [],
				'user_permissions' => (Auth::check()) ? Auth::user()->getPermissionsViaRoles()->pluck('name') : [],
				'max_files'    	   => 4
			]) !!}
		</script>
		{{-- APP.JS --}}
		@vite('resources/js/app.js')
		<!--begin::Javascript-->
		<script>var hostUrl = "{{ url('/') }}";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
		<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="assets/js/widgets.bundle.js"></script>
		<script src="assets/js/custom/widgets.js"></script>
		<script src="assets/js/custom/apps/chat/chat.js"></script>
		<script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
		<script src="assets/js/custom/utilities/modals/create-app.js"></script>
		<script src="assets/js/custom/utilities/modals/new-target.js"></script>
		<script src="assets/js/custom/utilities/modals/users-search.js"></script>
		<!--end::Custom Javascript-->
		{{-- FACTORY.JS --}}
		{{-- <script src="{{ asset('js/factory.js?v='.rand())}}"></script> --}}
		@stack('scripts')
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>