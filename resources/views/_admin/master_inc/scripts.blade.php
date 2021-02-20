
<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{URL::to('/assets/_admin/')}}/js/plugin/pace/pace.min.js"></script>

<!-- IMPORTANT: APP CONFIG -->
<script src="{{URL::to('/assets/_admin/')}}/js/app.config.js"></script>

<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
<script src="{{URL::to('/assets/_admin/')}}/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="{{URL::to('/assets/_admin/')}}/js/bootstrap/bootstrap.min.js"></script>

<!-- CUSTOM NOTIFICATION -->
<script src="{{URL::to('/assets/_admin/')}}/js/notification/SmartNotification.min.js"></script>

<!-- JARVIS WIDGETS -->
<script src="{{URL::to('/assets/_admin/')}}/js/smartwidgets/jarvis.widget.min.js"></script>

<!-- EASY PIE CHARTS -->
<script src="{{URL::to('/assets/_admin/')}}/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

<!-- SPARKLINES -->
<script src="{{URL::to('/assets/_admin/')}}/js/plugin/sparkline/jquery.sparkline.min.js"></script>

<!-- JQUERY VALIDATE -->
<script src="{{URL::to('/assets/_admin/')}}/js/plugin/jquery-validate/jquery.validate.min.js"></script>

<!-- JQUERY MASKED INPUT -->
<script src="{{URL::to('/assets/_admin/')}}/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

<!-- JQUERY SELECT2 INPUT -->
<script src="{{URL::to('/assets/_admin/')}}/js/plugin/select2/select2.min.js"></script>

{{--<script src="{{URL::to('/assets/_admin/')}}/js/libs/select2.full.min.js"></script>--}}
<!-- JQUERY UI + Bootstrap Slider -->
<script src="{{URL::to('/assets/_admin/')}}/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

<!-- browser msie issue fix -->
<script src="{{URL::to('/assets/_admin/')}}/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

<!-- FastClick: For mobile devices -->
<script src="{{URL::to('/assets/_admin/')}}/js/plugin/fastclick/fastclick.min.js"></script>

<!-- MomentJS: For date related js -->
<script src="{{URL::to('/assets/_admin/')}}/js/plugin/moment/moment.min.js"></script>

<!--[if IE 8]>
	<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
<![endif]-->

<!-- MAIN APP JS FILE -->
<script src="{{URL::to('/assets/_admin/')}}/js/app.min.js"></script>

<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
<!-- Voice command : plugin -->
<script src="{{URL::to('/assets/_admin/')}}/js/speech/voicecommand.min.js"></script>

<!-- SmartChat UI : plugin -->
<script src="{{URL::to('/assets/_admin/')}}/js/smart-chat-ui/smart.chat.ui.min.js"></script>
<script src="{{URL::to('/assets/_admin/')}}/js/smart-chat-ui/smart.chat.manager.min.js"></script>

<!-- Main custom js -->
<script src="{{URL::to('/assets/_admin/')}}/js/main.js"></script>

<script type="text/javascript">
	// DO NOT REMOVE : GLOBAL FUNCTIONS!
	$(document).ready(function() {
		pageSetUp();
	})
</script>

@yield('scripts')

