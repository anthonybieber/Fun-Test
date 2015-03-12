<?php

namespace Tools;

Class PageHandler {

  /**
   * string $page
   */
  private $pageContents;

  /**
   * Get the file of the web page we wish to parse
   *
   * @param  string $page location of the file
   *
   * @return string
   */
  public function getData($page) {

      $curl = curl_init();

      curl_setopt($curl, CURLOPT_POST, 0);
      curl_setopt($curl, CURLOPT_URL, $page);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36" );

      $content= curl_exec($curl);

      curl_close($curl);

      if(!$content) {
          return null;
      }

      $this->pageContents = $content;

      return $this->pageContents;
  }
}
