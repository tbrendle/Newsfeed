<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Utils\TwitterProvider;
use JsonSerializable;

/**
 * Author
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AuthorRepository")
 */
class Author implements JsonSerializable
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
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateDate", type="datetime")
     */
    private $updateDate;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_id", type="string", length=255)
     */
    private $twitterId;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="Tweet", mappedBy="author")
     **/
    private $tweets;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tweets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creationDate = new \DateTime();
    }

    public function toJson()
    {
        return json_encode(array(
            'id' => $this->twitterId,
            'type'=>  $this->type,
            'tweetss'=> $this->tweets->toArray()
        ));
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->twitterId,
            'type'=>  $this->type,
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Author
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
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Author
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set twitterId
     *
     * @param string $twitterId
     *
     * @return Author
     */
    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;

        return $this;
    }

    /**
     * Get twitterId
     *
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Author
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add tweet
     *
     * @param \AppBundle\Entity\Tweet $tweet
     *
     * @return Author
     */
    public function addTweet(\AppBundle\Entity\Tweet $tweet)
    {
        $tweet->setAuthor($this);
        $this->tweets[] = $tweet;
        return $this;
    }

    /**
     * Remove tweet
     *
     * @param \AppBundle\Entity\Tweet $tweet
     */
    public function removeTweet(\AppBundle\Entity\Tweet $tweet)
    {

        $this->tweets->removeElement($tweet);
        $tweet->setAuthor(null);
    }

    /**
     * Get tweets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTweets()
    {
        return $this->tweets;
    }
}
