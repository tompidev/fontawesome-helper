<?php
if ( (! empty($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') ||
     (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ||
     (! empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ) {
    $server_request_scheme = 'https';
} else {
    $server_request_scheme = 'http';
}
$pluginDir = $server_request_scheme . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

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

			<?php
			$id = 0;
			foreach ($class[1] as $fa) {
				$id = ++$id;
				$iconName = substr($fa, 3); // getting the icon name without the 'fa-' prefix
				echo "<i id='$cont[$id]' class='fa-icon fa-helper-icon m-1 p-lg-2 text-center border rounded-sm fa fa-3x $fa' data-name='fa-helper-icon' data-icon='$fa' data-iconname='$iconName'><div class='fa-helper-title'>$fa</div></i>";
			}
			?>

<script>
	$(document).ready(function() {

		/*
		 * Clipoard.js - Calling html element
		 */
		new ClipboardJS("#codeCopy");

		/*
		 * Create html formatted code from icon name and put into the code block when user clicks any icon on the list
		 */
		$('i[data-name="fa-helper-icon"]').click(function(e) {
			var title = $(this).attr('data-icon');
			var size = $('input[name="faIconSize"]:checked').val();
			if (size > 1) {
				var faClass = "fa-" + size + "x " + title;
				var faCode = "&lt;i class=\"fa fa-" + size + "x " + title + "\"&gt;&lt;/i&gt;";
			} else {
				var faClass = "fa fa-5x " + title;
				var faCode = "&lt;i class=\"fa " + title + "\"&gt;&lt;/i&gt;";
			}
			// $("#faSample i").switchClass(faClass);
			$("#code").html(faCode);
			$(".code-copy").removeClass("d-none");
		});

		/*
		 * Setting icon size and append into the html formatted code above
		 */
		$('input[name="faIconSize"]').click(function() {
			var size = this.value;
			var code = $("#code").html();
			var regex = /fa\sfa-+?.x/g;
			if (regex.test(code)) {
				if (size > 1) {
					var faSize = code.replace(regex, "fa fa-" + size + "x");
				} else {
					var faSize = code.replace(regex, "fa");
				}
			} else if (size > 1) {
				var regex = /fa\s/g;
				var faSize = code.replace(regex, "fa fa-" + size + "x ");
			}
			$("#code").html(faSize);
		});

		/*
		 * Empty code block, hide copy button and set icon size radio buttons to unchecked on click Reset button
		 */
		$('#resetBtn').click(function() {
			$("#code").html("");
			$(".code-copy").addClass("d-none");
			$('input[name="faIconSize"]').prop("checked", false);
			$('#faIconSize1').prop("checked", true);
			// $("#faIconSearch").val("");
		});

		/*
		 * Empty modal's 'inputs' and hide copy button again when modal window closed
		 */
		$("#faModal").on("hidden.bs.modal", function() {
			$("#code").html("");
			$("#faIconSearch").val("");
			$(".code-copy").addClass("d-none");
			$('input[name="faIconSize"]').prop("checked", false);
			$('#faIconSize1').prop("checked", true);
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

		// search icons
		// get input field and add 'keyup' event listener
		let searchInput = document.querySelector('#faIconSearch');
		// let searchInput = document.querySelector('#searchFaIcon');
		searchInput.addEventListener('keyup', search);

		// get all elements with data-iconname attribute
		let data = document.querySelectorAll('[data-iconname]');
		let searchTerm = '';
		let name = '';

		function search(e) {
			// get input fieled value and change it to lower case
			searchTerm = e.target.value.toLowerCase();

			data.forEach((elem) => {
				// navigate to p in the title, get its value and change it to lower case
				name = elem.textContent.toLowerCase();
				// if search term not in the title's title hide the title. otherwise, show it.
				name.includes(searchTerm) ? elem.style.display = '' : elem.style.display = 'none';
			});
		}

	});
</script>