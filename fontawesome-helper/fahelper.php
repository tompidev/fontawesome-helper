<?php
$pluginDir = $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

$clipboardJs = $pluginDir . '/clipboard.min.js';
$facss = $pluginDir . '/css/line-awesome/css/line-awesome-font-awesome.min.css';

echo "<script src='$clipboardJs'></script>";

$fontawesome = file_get_contents($facss);
preg_match_all('/"}.(.+?):before/', $fontawesome, $class); // icon name e.g. 'fa fa-adjust'
preg_match_all('/:"\\\(.+?)"}/', $fontawesome, $contents); // css ID excluded backslash '\'

$cont = array();
foreach ($contents[1] as $content) {
	$cont[] = $content; // getting css 'content' id of all icons
}
?>

<div class="container">
	<div class="row">
		<div class="col-xs-1-12">


			<?php
			$id = 0;
			foreach ($class[1] as $fa) {
				$id = ++$id;
				echo "<i id='$cont[$id]' class='fa-icon fa-helper-icon m-1 p-2 text-center border rounded-sm fa fa-3x $fa' data-name='fa-helper-icon' data-icon='$fa'><div class='fa-helper-title'>$fa</div></i>";
			}
			?>

		</div>
	</div>
</div>
<script>
	$(document).ready(function() {

		/*
		 * Clipoard.js - Calling html element
		 */
		new ClipboardJS("#codeCopy");

		/*
		 * Create html formatted code from icon name and put into the code block when user click any icon on the list
		 */
		$('i[data-name="fa-helper-icon"]').click(function(e) {
			var title = $(this).attr('data-icon');
			var id = $(this).attr("id");
			$("#code").html("&lt;i class=\"fa " + title + "\"&gt;&lt;/i&gt;");
			$(".code-copy").removeClass("d-none");
		});

		/*
		 * Empty modal 'code' block and hide copy button again when modal window closed
		 */
		$("#faModal").on("hidden.bs.modal", function() {
			$("#code").html("");
			$(".code-copy").addClass("d-none");
		});

		/*
		 * Show alert when code copied to clipboard
		 */
		$('#faModal').on('shown.bs.modal', function() {
			$(".code-copy").click(function() {
				$(".notify").toggleClass("notifyactive");
				$("#notifyType").toggleClass("success");

				setTimeout(function() {
					$(".notify").removeClass("notifyactive");
					$("#notifyType").removeClass("success");
				}, 2000);
			});
		});
	})
</script>