<?php

/**
 * Dirty screen scraper to get existing speakers from the old website
 */

function processName(array &$personData, $oneline)
{
    $matches = [];
    $found = preg_match("/\"page-header\"> *\<h1\>.*\<\/h1\>/", $oneline, $matches);

    if ($found) {
        $speakerDetails = $matches[0];

        $name = preg_replace("/.*\<h1\>/", '', $speakerDetails);
        $name = preg_replace("/\<br\>.*/", '', $name);

        if (false === strpos($name, '</h1>')) {
            $description = preg_replace("/.*\<small\>/", '', $speakerDetails);
            $description = preg_replace("/\<\/small\>.*/", '', $description);
            $description = strip_tags($description);
        } else {
            $name = str_replace('</h1>', '', $name);
            $description = '';
        }

        $name = trim($name);
        $personData['name'] = $name;
        $personData['description'] = $description;
    }
}

function processMeetupId(array &$personData, $html)
{
//    <a href="http://www.meetup.com/php-sw/members/14077610">
//              <i class="fa fa-calendar"></i> Meetup profile
//    </a>

    $matches = [];
    $found = preg_match('#href="http://www.meetup.com/php-sw/members/.*?"#', $html, $matches);

    if ($found) {
        $meetupId = preg_replace('#href="http://www.meetup.com/php-sw/members/#', '', $matches[0]);
        $meetupId = preg_replace('#"#', '', $meetupId);
        $personData['meetup-id'] = $meetupId;
    }
}

function processTwitter(array &$personData, $html)
{
    // https://twitter.com/woogoose"

    $matches = [];
    $found = preg_match_all('#https://twitter.com/.*?"#', $html, $matches);

    if ($found) {
        foreach ($matches[0] as $match) {
            $twitter = preg_replace('#https://twitter.com/#', '', $match);
            $twitter = preg_replace('#"#', '', $twitter);

            if ('phpsw' != $twitter) {
                $personData['twitter-handle'] = $twitter;
            }
        }
    }
}

// http://photos2.meetupstatic.com/photos/member

function processPhoto(array &$personData, $html)
{
    // https://twitter.com/woogoose"

    $matches = [];
    $found = preg_match('#http://photos..meetupstatic.com/photos/member/.*?jpeg#', $html, $matches);

    if ($found) {
        $personData['photo-url'] = $matches[0];
    }
}

function processFile($url)
{
    $text = file_get_contents($url);
    $html = preg_replace("/\r|\n/", '', $text);

    $personData = [];
    processName($personData, $html);
    processMeetupId($personData, $html);
    processTwitter($personData, $html);
    processPhoto($personData, $html);

    return $personData;
}

function processSpeakers($url)
{
    $html = file_get_contents($url);

    $people = [];

    $matches = [];
    $found = preg_match_all('#href="speakers\/.*?"#', $html, $matches);
    if ($found) {
        foreach ($matches[0] as $match) {
            $speakerUrl = preg_replace("#href=\"speakers\/#", '', $match);
            $speakerUrl = str_replace('"', '', $speakerUrl);
            if (substr_count($speakerUrl, '-') < 3) {
                $people[$speakerUrl] = processFile("$url/$speakerUrl");
            }
        }
    }

    var_dump($people);

    return $people;
}

function saveSpeakers($speakers, $directory)
{
    foreach ($speakers as $slug => $speaker) {
        $fileName = "$directory/$slug";
        if (!file_exists($fileName)) {
            file_put_contents($fileName, json_encode($speaker, JSON_PRETTY_PRINT));
        }
    }
}

$speakers = processSpeakers('http://phpsw.uk/speakers');
saveSpeakers($speakers, '/tmp/speakers');
