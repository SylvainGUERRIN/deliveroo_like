<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursePriceRepository")
 */
class CoursePrice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $atRestaurant;

    /**
     * @ORM\Column(type="float")
     */
    private $distance;

    /**
     * @ORM\Column(type="boolean")
     */
    private $getAtClient;

    /**
     * @ORM\Column(type="boolean")
     */
    private $costs;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Course", inversedBy="coursePrice", cascade={"persist", "remove"})
     */
    private $course;

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAtRestaurant(): ?bool
    {
        return $this->atRestaurant;
    }

    /**
     * @param mixed $atRestaurant
     * @return $this
     */
    public function setAtRestaurant($atRestaurant): self
    {
        $this->atRestaurant = $atRestaurant;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDistance(): ?float
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     * @return $this
     */
    public function setDistance($distance): self
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGetAtClient(): ?bool
    {
        return $this->getAtClient;
    }

    /**
     * @param mixed $getAtClient
     * @return $this
     */
    public function setGetAtClient($getAtClient): self
    {
        $this->getAtClient = $getAtClient;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCosts(): ?bool
    {
        return $this->costs;
    }

    /**
     * @param mixed $costs
     * @return $this
     */
    public function setCosts($costs): self
    {
        $this->costs = $costs;
        return $this;
    }

    /**
     * @return Course |null
     */
    public function getCourse(): ?Course
    {
        return $this->course;
    }

    /**
     * @param Course |null $course
     * @return $this
     */
    public function setCourse(?Course $course): self
    {
        $this->course = $course;
        return $this;
    }

}
