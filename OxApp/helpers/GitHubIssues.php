<?php
/**
 * Created by OxGroup.
 * User: aliaxander
 * Date: 08.05.16
 * Time: 12:10
 */

namespace OxApp\helpers;

/**
 * Class GitHubIssues
 *
 * @package OxApp\modules
 */
class GitHubIssues
{
    public static $gitUrl;
    
    /**
     * @param $title
     * @param $message
     *
     * @throws \GitHubClientException
     */
    public static function addIssue($title, $message, $gitRepo)
    {
        //git@github.com:OxGroup/DataBase.git
        $gitRepo = explode("/", $gitRepo);
        $client = new \GitHubClient();
        $client->setCredentials("webci", "6LxOyIoSnJG8zYCQeARE");
        $i = 0;
        $add = true;
        while (++$i) {
            $client->setPage($i);
            $client->setPageSize(100);
            $issues = $client->issues->listIssues(mb_strtolower($gitRepo[0]), $gitRepo[1]);
            
            if (!empty($issues)) {
                foreach ($issues as $issue) {
                    //echo get_class($issue) . "[" . $issue->getBody() . "]: " . $issue->getTitle() . "\n";
                    $iMessage = md5($issue->getBody());
                    $iTitle = md5($issue->getTitle());
                    if ($iMessage == md5($message) && md5($title) == $iTitle && $issue->getState() == "open") {
                        $add = false;
                    }
                }
            } else {
                break;
            }
        }
        var_dump($add);
        if ($add == true) {
            try {
                print_r($client->issues->createAnIssue(mb_strtolower($gitRepo[0]), $gitRepo[1], $title, $message));
            } catch (\Exception $e) {
                print_r($e);
            }
        }
    }
}
