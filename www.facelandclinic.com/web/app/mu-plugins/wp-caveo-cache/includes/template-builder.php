<?php

class WP_Caveo_Cache_Template_Builder
{
	public $_base_path = '';

	// In case we want to use a different theme
	public $_theme = '2020';

	public $_theme_path = 'resources/themes/';

	public $_view_path = 'resources/views/';

	public $_view_data = [];

	// Page(s) to output
	public $_pages = [];

	public function __construct ()
	{
		$this->setBasePath();
		$this->setThemePath();
		$this->setViewPath();
	}

	public function setBasePath (): void
	{
		$this->_base_path = str_replace('includes', '', plugin_dir_path(__FILE__));
	}

	public function setThemePath (): void
	{
		$this->_theme_path = $this->_base_path . $this->_theme_path;
	}

	public function setViewPath (): void
	{
		$this->_view_path = $this->_base_path . $this->_view_path;
	}

	/**
	 * @param String $pathToPage
	 *
	 * @return $this
	 * @throws ErrorException
	 */
	public function addPage (String $pathToPage): self
	{
		$view = $this->getViewName($pathToPage);

		if (! file_exists($view)) {
			throw new ErrorException('Page you\'re trying to load does not exists: '. $view);
		}

		$this->_pages[] = $view;

		return $this;
	}

	/**
	 * @param array $pathToPages
	 *
	 * @return $this
	 * @throws ErrorException
	 */
	public function addPages (Array $pathToPages): self
	{
		foreach ($pathToPages as $path_to_page) {
			$this->addPage($path_to_page);
		}

		return $this;
	}

	public function addViewData(Array $data): self
	{
		$this->_view_data = $data;

		return $this;
	}

	private function getPages (): string
	{
		$html = '';

		foreach ($this->_pages as $page) {
			$html .= $this->renderPHPView($page);
		}

		return $html;
	}

	private function getTheme (): string
	{
		$theme = $this->_theme_path . $this->_theme . '/theme.view.php';

		if (! file_exists($theme)) {
			throw new ErrorException('Theme you\'re trying to load does not exists: '. $theme);
		}

		return $this->renderPHPView($theme);
	}

	private function getViewName (String $pathToPage): string
	{
		$pathToPage = str_replace(['.view', '.php'], '', $pathToPage);
		$pathToPage .= '.view.php';

		return $this->_view_path . $pathToPage;
	}

	private function setContent (String $template, String $pages): string
	{
		return str_replace('@content', $pages, $template);
	}

	protected function buildHTML (): string
	{
		$template = $this->getTheme();
		$pages = $this->getPages();

		return $this->setContent($template, $pages);
	}

	protected function renderPHPView($path)
	{
		extract($this->_view_data, EXTR_PREFIX_SAME, '');

		ob_start();
		include($path);

		return ob_get_clean();
	}

	public function getHTML (): string
	{
		return $this->buildHTML();
	}
}
