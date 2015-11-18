<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Tweet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TweetRepository")
 */
class Tweet implements JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_id", type="string")
     */
    private $twitterId;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=255)
     */
    private $lang;

    /**
     * @var string
     *
     * @ORM\Column(name="display_url", type="string", length=255)
     */
    private $displayUrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="Author", inversedBy="tweets")
     **/
    private $author;

    /**
     * Constructor
     */
    public function __construct($officialTweet)
    {
        if(property_exists($officialTweet, 'retweeted_status'))
            $this->creationDate = new \DateTime($officialTweet->retweeted_status->created_at);
        else 
            $this->creationDate = new \DateTime($officialTweet->created_at);
        $this->twitterId = $officialTweet->id_str;
        $this->lang = $officialTweet->lang;
        if(property_exists($officialTweet->entities, 'media')){
            $medias=$officialTweet->entities->media;
            $this->displayUrl=$medias[0]->media_url;
        }
    }

    public function jsonSerialize()
    {
        return array(
            'lang'=>$this->lang,
            'favCount'=>$this->favCount,
            'displayUrl'=>$this->displayUrl,
            'creationDate'=>$this->creationDate,
            'author'=>$this->author,
            'rtCount'=>$this->rtCount,
            'id'=>$this->twitterId,
            'text'=>$this->text
        );
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set twitterId
     *
     * @param integer $twitterId
     *
     * @return Tweet
     */
    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;

        return $this;
    }

    /**
     * Get twitterId
     *
     * @return integer
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /**
     * Set lang
     *
     * @param string $lang
     *
     * @return Tweet
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set displayUrl
     *
     * @param string $displayUrl
     *
     * @return Tweet
     */
    public function setDisplayUrl($displayUrl)
    {
        $this->displayUrl = $displayUrl;

        return $this;
    }

    /**
     * Get displayUrl
     *
     * @return string
     */
    public function getDisplayUrl()
    {
        return $this->displayUrl;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Tweet
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\Author $author
     *
     * @return Tweet
     */
    public function setAuthor(\AppBundle\Entity\Author $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\Author
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
