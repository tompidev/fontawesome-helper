<?php

/**
 *  @package        :  FontAwesome Helper
 *  @author         :  Tompidev
 *  @website        :  https://github.com/tompidev
 *  @email          :  support@tompidev.com
 *  @license        :  MIT
 *
 *  @last-modified  :  2021-07-09 20:08:55 CET
 *  @release        :  1.0.7
 **/

class pluginFontAwesomeHelper extends Plugin
{

	/*
	* Create new global variable for plugin 'codeName'
	*/
	public $pluginName = "faPlugin";

	public function init()
	{
		$this->dbFields = array(
			'faOnSidebar' => true
		);
	}

	public function form()
	{
		global $L;
		global $site;

		$html  = '<div class="alert alert-primary" role="alert">';
		$html .= $this->description();
		$html .= '</div>';

		/*
		* Show warning message about new plugin release
		*/
		$html .= '<div class="row d-none" id="'. $this->pluginName .'VersionAlert">' . PHP_EOL;
		$html .= '<div class="col">' . PHP_EOL;
		$html .= '<div class="alert alert-warning alert-dismissible border" role="alert">' . $L->g('new-release-warning') . '' . PHP_EOL;
		$html .= '<a id="learnMore" type="button" class="btn btn-success btn-sm text-light ml-2" data-toggle="modal" data-target="#'. $this->pluginName .'ReleaseNotesModal">' . $L->g('Learn more') . '</a>' . PHP_EOL;
		$html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' . PHP_EOL;
		$html .= '<span aria-hidden="true">&times;</span>' . PHP_EOL;
		$html .= '</button>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;

		/*
		* Select to show or hide menuitem on sidebar
		*/
		$html .= PHP_EOL . '<div>';
		$html .= '<label for="faOnSidebar" style="font-size:1.25rem">' . $L->g('Show or hide on Sidebar') . '</label>' . PHP_EOL;
		$html .= '<select id="faOnSidebar" name="faOnSidebar">' . PHP_EOL;
		$html .= '<option value="true" ' . ($this->getValue('faOnSidebar') === true ? 'selected' : '') . '>' . $L->g('Enabled') . '</option>' . PHP_EOL;
		$html .= '<option value="false" ' . ($this->getValue('faOnSidebar') === false ? 'selected' : '') . '>' . $L->g('Disabled') . '</option>' . PHP_EOL;
		$html .= '</select>' . PHP_EOL;
		$html .= '<small class="text-muted">' . $L->g('Show or hide FA helper menuitem on Sidebar') . '</small>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;

		/*
		* Calling modal "Showroom"
		*/
		$html .= '<a id="loadFaModal" class="btn btn-info btn-lg mt-4 text-white" data-toggle="modal" data-target="#faModal" role="button">' . $L->get('Open showroom') . '</a>';

			/*
		* App footer for plugin version and developer's urls
		*/
		$html .= PHP_EOL . '<div class="text-center pt-3 mt-4 border-top text-muted">' . PHP_EOL;
		$html .= $this->name() . ' - v' . $this->version() . ' @ ' . date('Y') . ' by ' .  $this->author() . PHP_EOL;
		$html .= '</div>' . PHP_EOL;
		$html .= '<div class="text-center">' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-globe" href="https://www.tompidev.com/" target="_blank" title="Visit TompiDev\'s Website"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-github" href="https://www.github.com/tompidev" target="_blank" title="Visit TompiDev on Github"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-twitter" href="https://www.twitter.com/tompidev" target="_blank" title="Visit TompiDev on Twitter"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-envelope" href="mailto:support@tompidev.com/?subject=Question%20about%20' . $this->name() . '" title="Send me an email"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-cubes" href="https://www.tompidev.com/fontawesome-helper" target="_blank" title="Plugin\'s website on tompidev.com"></a>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;

		/*
		* Modal for Release notes
		*/
		$html .= '
<div class="modal fade" id="'. $this->pluginName .'ReleaseNotesModal" tabindex="-1" aria-labelledby="'. $this->pluginName .'ReleaseNotesModal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
<div class="modal-content">
 <div class="modal-header text-center">
	 <h4 class="modal-title w-100">' . $L->g('Release Notes') . '</h4>
 </div>
 <div class="modal-body">
	 <div calss="container">
				<div class="row">
						<div class="col-5 font-weight-bold pr-1 mr-2">' . $L->g('Package') . ':</div>
						<div id="'. $this->pluginName .'PackageName"></div>
				</div>
				<div class="row">
						<div class="col-5 font-weight-bold pr-1 mr-2">' . $L->g('Current version') . ':</div>
						<div id="'. $this->pluginName .'CurrentVersion"></div>
				</div>
				<div class="row">
						<div class="col-5 font-weight-bold pr-1 mr-2">' . $L->g('New version') . ':</div>
						<div id="'. $this->pluginName .'NewVersion"></div>
				</div>
				<div class="row">
						<div class="col-5 font-weight-bold pr-1 mr-2">' . $L->g('Release date') . ':</div>
						<div id="'. $this->pluginName .'ReleaseDate"></div>
				</div>
	 </div>
	 <h5 class="my-3 pt-3 border-top">' . $L->g('What\'s new in this release') . '</h5>
	 <div class="pl-3" id="'. $this->pluginName .'ReleaseNotes"></div>
	 <div id="usufelLinks" class="mt-3 pt-3 border-top">
	 <h5>' . $L->g("Useful Links") . '</h5>
			 <a href="http://demo.tompidev.com/" target="_blank">Demo admin<span class="fa fa-external-link ml-2"></span></a>(' . $L->g('Try Tompidev\'s plugins and themes for FREE') . ')<br>
			 <a href="https://tompidev.com/" target="_blank">Developer\'s website<span class="fa fa-external-link ml-2"></span></a>(' . $L->g('All plugins and themes from Tompidev') . ')
	 </div>
 </div>
 <div class="modal-footer justify-content-center">
		<a id="downloadLink" class="btn btn-primary" href="" target="_blank"><i class="fa fa-download"></i>' . $L->g('Download release') . '</a>
		<a id="changelogLink" class="btn btn-primary" href="" target="_blank"><i class="fa fa-info-circle"></i>' . $L->g('Changelog') . '</a>
		<a id="github" class="btn btn-primary" href="" target="_blank"><i class="fa fa-github"></i>Github</a>
 </div>
</div>
</div>
</div> ' . PHP_EOL;

		/*
		* Modal for Fontawesome icons
		*/
		$html .= '
		<div class="modal fade fa-modal-xl" id="faModal" tabindex="-1" role="dialog" aria-labelledby="faModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header justify-content-md-center">
					<div class="notify"><span id="notifyType" class=""></span></div> <!-- Container for alert when code copied to clipboard-->
					<div class="container">
						<div class="input-group mb-3 border rounded bg-light">
							<pre>
								<span class="code-copy border-right d-none" role="button"><i id="codeCopy" class="fa fa-paste btn pb-0" aria-hidden="true" title="' . $L->get('Copy code to clipboard') . '" data-clipboard-target="#code"></i></span>
								<code id="code" class="language-html"></code>
							</pre>
							<div class="input-group-append reset-button">
								<button id="resetBtn" type="button" class="btn btn-primary text-uppercase" data-dismiss="code" aria-label="Reset">' . $L->get('Clean') . '
								</button>
							</div>
						</div>
						<div class="input-group td-input-group">
							<div class="input-group-prepend w-auto">
								<div class="input-group-text td-input-group-text">
									<input class="mr-1" type="radio" name="faIconSize" id="faIconSize2" value="2">
										<span class="form-check-label mt-0 mr-2" for="faIconSize2">2x</span>
									<input class="mr-1" type="radio" name="faIconSize" id="faIconSize3" value="3">
										<span class="form-check-label mt-0 mr-2" for="faIconSize3">3x</span>
									<input class="mr-1" type="radio" name="faIconSize" id="faIconSize4" value="4">
										<span class="form-check-label mt-0 mr-2" for="faIconSize4">4x</span>
									<input class="mr-1" type="radio" name="faIconSize" id="faIconSize5" value="5">
										<span class="form-check-label mt-0 mr-2" for="faIconSize5">5x</span>
									<input class="mr-1" type="radio" name="faIconSize" id="faIconSize1" value="1" checked>
										<span class="form-check-label mt-0" for="faIconSize1">' . $L->get('Default') . ' (1x)</span>
								</div>
							</div>
							<input id="faIconSearch" type="text" class="form-control faIconSearch" placeholder="' . $L->get('Type to search icons') . '">
						</div>
					</div>
				</div>
				<div class="modal-body pt-0 px-0">
					<div id="faContent" class="container mt-3"></div>
				</div>
			</div>
		</div>
	</div>
			' . PHP_EOL;

		return $html;
	}

	public function adminHead()
	{
		$html = '<link rel="stylesheet" type="text/css" href="' . HTML_PATH_PLUGINS . 'fontawesome-helper/css/style.css">' . PHP_EOL;

		return $html;
	}

	public function adminSidebar()
	{
		global $L;

		$html = '';
		if ($this->getValue('faOnSidebar') && $this->getValue('faOnSidebar') == true) {
			$html = '<a id="faNavitem"  class="nav-link" href="' . HTML_PATH_ADMIN_ROOT . 'configure-plugin/' . $this->className() . '" title="' . $L->get('Open Settings page of '.$this->name(). ' plugin') . '">' . $this->name() . '<i id="'. $this->pluginName .'VersionMenuAlert" title="' . $L->get('new-release-warning') . '"></i></a>';
		}

		return $html;
	}

	public function adminBodyEnd()
	{
		global $L;

		$scripts = '<script>' . PHP_EOL;

		/*
		* Loading file into modal
		*/
		$file = DOMAIN_PLUGINS . "fontawesome-helper/fahelper.php";

		$scripts .= '$("#loadFaModal").click(function(){' . PHP_EOL;
		$scripts .= '$("#faContent").load("' . $file . '")' . PHP_EOL;
		$scripts .= '})' . PHP_EOL;

		$scripts .= '</script>' . PHP_EOL;

		/*
		* Version check script
		*
		* Reading data from remote json file
		*/
		$scripts .= '<script>

		function check'.$this->pluginName. 'Version() {

				// console.log("[INFO] [PLUGIN VERSION] Getting list of versions of '.$this->name(). ' plugin.");

				$.ajax({
						url: "https://tompidev.com/release-info/json/'.$this->className(). '.json",
						method: "GET",
						dataType: "json",
						success: function(json) {
								if (json.'. $this->pluginName .'.newVersion > "'.$this->version().'") {
										console.log("[INFO] [PLUGIN VERSION] New '.$this->name(). ' plugin version is available: v" + json.'. $this->pluginName .'.newVersion);
										$("#'. $this->pluginName .'PackageName").html(json.'. $this->pluginName .'.package);
										$("#'. $this->pluginName .'CurrentVersion").html("'.$this->version().'");
										$("#'. $this->pluginName .'NewVersion").html( json.'. $this->pluginName .'.newVersion );
										$("#'. $this->pluginName .'ReleaseDate").html( json.'. $this->pluginName .'.releaseDate );
										var changelogObj, i, j, x = "";
										changelogObj = [ json.'. $this->pluginName .'.changelog ];
										console.log(changelogObj);
										for (i in json.'. $this->pluginName .'.changelog) {
												x += "<h5 class=\"mt-2\">" + json.'. $this->pluginName .'.changelog[i].action + "</h5>";
												for (j in json.'. $this->pluginName .'.changelog[i].items) {
												x += "<span class=\"fa fa-arrow-right ml-2\"></span>" + json.'. $this->pluginName .'.changelog[i].items[j] + "<br>";
												}
										}
										$("#'. $this->pluginName .'ReleaseNotes").html( x );
										$("#'. $this->pluginName .'VersionAlert").removeClass("d-none");
										$("#'. $this->pluginName .'VersionMenuAlert").addClass("fa fa-bell mr-1 text-warning float-right");
										$("#downloadLink").attr("href",  json.'. $this->pluginName .'.downloadLink );
										$("#changelogLink").attr("href", json.'. $this->pluginName .'.changelogLink );
										$("#github").attr("href", json.'. $this->pluginName .'.github );
								}
						},
						error: function(json) {
								console.log("[WARN] [PLUGIN VERSION] There is some issue to get the version status of '.$this->name(). ' plugin.");
						}
				});
		}
		check'.$this->pluginName. 'Version();
		</script>' . PHP_EOL;
		return $scripts;
	}
}
