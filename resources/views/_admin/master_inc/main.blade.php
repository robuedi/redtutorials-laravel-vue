<!-- MAIN PANEL -->
<main id="main" role="main">
	<!-- RIBBON -->
	<section id="ribbon">

		<span class="ribbon-button-alignment"> 
			<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh" rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true"><i class="fa fa-refresh"></i></span> 
		</span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			@yield('breadcrumbs')
		</ol>
		<!-- end breadcrumb -->

	</section>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<section id="content">

		@yield('content')

	</section>
	<!-- END MAIN CONTENT -->
</main>

<!-- This is for delete btn (confirmation request) -->
<div class="modal fade" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="confirm_modal_header" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="confirm_modal_header">Please confirm</h4>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<a href="javascript:void(0);" class="btn btn-default" data-dismiss="modal">No</a>
				<a href="javascript:void(0);" class="btn btn-primary modal-yes">Yes</a>
			</div>
		</div>
	</div>
</div>
<form id="delete_form" method="POST" class="hidden" enctype="application/x-www-form-urlencoded"  >
	<input type="hidden" name="_method" value="DELETE">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
</form>