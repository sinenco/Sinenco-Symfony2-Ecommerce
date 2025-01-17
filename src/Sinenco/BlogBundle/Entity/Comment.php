<?php

namespace Sinenco\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Comment
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
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;

    
    /**
     *  @ORM\ManyToOne(targetEntity="Sinenco\UserBundle\Entity\User", cascade={"persist"})
     *  @ORM\JoinTable()
     *  @ORM\JoinColumn(nullable=true)
     * */
    private $user;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Sinenco\BlogBundle\Entity\Post", inversedBy="comments", cascade={"persist"})
     *  @ORM\JoinTable()
     *  @ORM\JoinColumn(nullable=true)
     * */
    private $post;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Sinenco\BlogBundle\Entity\SubComment", mappedBy="comment", cascade={"persist"})
     * */
    private $comments;
    
    
    /**
     * @var text
     *
     * @ORM\Column(type="text")
     */
    private $content;
    
    
    public function __toString() {
        $length = strlen($this->content)-1 ;
        if ( $length > 20 ){
            $length = 20 ; 
        }
        $cut = substr($this->content, 0, $length) ; 
        if ( $cut == "" ){
            return "new";
        }
        return $cut ; 
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Comment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = New \DateTime ;
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set user
     *
     * @param \Sinenco\UserBundle\Entity\User $user
     *
     * @return Comment
     */
    public function setUser(\Sinenco\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Sinenco\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add comment
     *
     * @param \Sinenco\BlogBundle\Entity\Comment $comment
     *
     * @return Comment
     */
    public function addComment(\Sinenco\BlogBundle\Entity\SubComment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \Sinenco\BlogBundle\Entity\Comment $comment
     */
    public function removeComment(\Sinenco\BlogBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set post
     *
     * @param \Sinenco\BlogBundle\Entity\Post $post
     *
     * @return Comment
     */
    public function setPost(\Sinenco\BlogBundle\Entity\Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Sinenco\BlogBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }
}
