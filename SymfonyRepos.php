<?php

//Autoload files will be merged so both do not have to be included
require __DIR__ . '/vendor/autoload.php';
require 'autoload.php';

use Views\IndexView;
use Helpers\SymfonyReposHelper;
	
	$view = IndexView::getView();

	if(isset($_GET['SymfonyBundleRequestButton'])) {
		
		$helper = new SymfonyReposHelper();

		$content       = $helper->getContent();
		$parsedContent = $helper->getParsedContent($content);

		$helper->sortContent($parsedContent);

		$helper->downloadCsv($parsedContent);
	}




