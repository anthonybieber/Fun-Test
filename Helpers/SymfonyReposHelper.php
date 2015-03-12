<?php

namespace Helpers;

require __DIR__ . '/../vendor/autoload.php';

use Tools\PageHandler;

class SymfonyReposHelper {
	
	/**
	 * Query the github api and return the content in array format
	 * 
	 * @return array
	 */
	public function getContent()
	{
		$pageHandler  = new PageHandler();
		$content      = $pageHandler->getData('https://api.github.com/orgs/symfony/repos');

		if(is_null($content)) {
			throw new Exception("No Content returned", 1);	
		}

		return json_decode($content, true);
	}

	/**
	 * Parse the content received from the github api response
	 * 
	 * @param  array $content
	 * 
	 * @return array
	 */
	public function getParsedContent($content)
	{
		$parsedContent = [];

		foreach ($content as $bundleData) {
			$data = [];

			$data['Repository Name'] = $bundleData['full_name'];
			$data['Number Of Watchers'] = $bundleData['watchers_count'];
			$data['Coding Language'] = $bundleData['language'];

			$parsedContent[] = $data;
		}

		return $parsedContent;
	}

	/**
	 * Sort the parsed content by repository name
	 * 
	 * @param  array &$parsedcontent
	 * 
	 * @return array
	 */
	public function sortContent(&$parsedContent)
	{
		usort($parsedContent, function($a, $b) {
    		return $a['Repository Name'] > $b['Repository Name'];
		});

		return $parsedContent;
	}

	/**
	 * Download the csv file through use of the output buffer.
	 * 
	 * @param  array $parsedContent
	 */
	public function downloadCsv($parsedContent)
	{	
		//Necessary to html is not returned with data
		ob_end_clean();

		header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=SymfonyRepos.csv'); 

		$file = fopen('php://output', 'w');
    fputcsv($file, array_keys($parsedContent['0']));

    foreach($parsedContent as $values){
        fputcsv($file, $values);
    }

    fclose($file);
	}
}