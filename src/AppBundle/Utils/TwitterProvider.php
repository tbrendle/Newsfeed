<?php

namespace AppBundle\Utils;

use AppBundle\Utils\TwitterAPIExchange;

class TwitterProvider
{
	private $settings;

	public function __construct($settings)
    {
        $this->settings= $settings;
	}

	public function getTweets($id)
	{
		$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
		$getfield = '?screen_name='.$id.'&count=20&include_rts=false';
		$twitter = new TwitterAPIExchange($this->settings);
		return json_decode($twitter->setGetfield($getfield)
		             ->buildOauth($url, "GET")
		             ->performRequest());
	}
}
