<?php

/**
 *  @package        :  FontAwesome Helper
 *  @author         :  Tompidev
 *  @website        :  https://github.com/tompidev
 *  @email          :  support@tompidev.com
 *  @license        :  MIT
 *
 *  @last-modified  :  2020-09-07 21:08:15 CET
 *  @release        :  1.0.3
 **/

class pluginFontAwesomeHelper extends Plugin
{

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
		* Displaying the plugin version
		*/
		$html .= PHP_EOL . '<div class="text-center pt-3 mt-4 border-top text-muted">' . PHP_EOL;
		$html .= $this->name() . ' - v' . $this->version() . ' @ ' . date('Y') . ' by ' .  $this->author() . PHP_EOL;
		$html .= '</div>' . PHP_EOL;
		$html .= '<div class="text-center">' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-globe" href="' . $this->website() . '" target="_blank" title="Visit TompiDev\'s Website"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-github" href="' . $site->github() . '" target="_blank" title="Visit TompiDev on Github"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-twitter" href="' . $site->twitter() . '" target="_blank" title="Visit TompiDev on Twitter"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-envelope" href="mailto:' . $this->email() . '?subject=Question%20about%20'.$this->name().'" title="Send me an email"></a>' . PHP_EOL;
		$html .= '<a class="fa fa-2x fa-cubes" href="https://www.tompidev.com/fontawesome-helper" target="_blank" title="Plugin\'s website on tompidev.com"></a>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;

		/*
		* Modal for Fontawesome icons
		*/
		$html .= '
<div class="modal fade fa-modal-xl" id="faModal" tabindex="-1" role="dialog" aria-labelledby="faModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header justify-content-md-center">
				<div class="notify"><span id="notifyType" class=""></span></div> <!-- Container for alert when code copied to clipboard-->
				<div class="col col-lg-8 px-0 border rounded bg-light">
					<pre>
						<span class="code-copy border-left" role="button"><i id="codeCopy" class="fa fa-paste btn" aria-hidden="true" title="' . $L->get('Copy code to clipboard') . '" data-clipboard-target="#code"></i></span>
						<code id="code" class="language-html"></code>
					</pre>
				</div>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
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

		$html = '';
		if ($this->getValue('faOnSidebar')) {
			$html = '<a id="faNavitem" class="nav-link" href="' . HTML_PATH_ADMIN_ROOT . 'configure-plugin/' . $this->className() . '">' . $this->name() . '</a>';
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

		return $scripts;
	}
}
