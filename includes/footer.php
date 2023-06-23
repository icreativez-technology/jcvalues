					<!--begin::Footer-->
					<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
					    <!--begin::Container-->
					    <div class="container-full d-flex flex-column flex-md-row flex-stack">
					        <!--begin::Copyright-->
					        <div class="text-dark order-2 order-md-1">

					        </div>
					        <!--end::Copyright-->
					        <!--begin::Menu-->
					        <!-- <ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
								<li class="menu-item">
									<a href="https://jc-valves.com/" target="_blank" class="menu-link px-2">JC Valves © 2022. All rights reserved.</a>
								</li>
							</ul> -->
					        <!--end::Menu-->
					    </div>
					    <!--end::Container-->
					</div>
					<!--end::Footer-->
					<script>
$('#pageRange').on('change', function() {
    orginUrl = window.location.href.replace(window.location.search, '');
    let range = $('#pageRange').val();
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    if (urlParams.has('page')) {
        urlParams.set('page', '1');
    }
    urlParams.set('limit', range);
    let newUrl = [orginUrl, urlParams.toString()].join('?');
    return window.location.href = newUrl;
})

$('.set-url').on('click', function() {
    return localStorage.setItem('url', window.location.href);
});
					</script>