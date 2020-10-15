<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client;

    /**
     * @ORM\Column(type="time")
     */
    private $deliverabilityTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Biker", inversedBy="courses")
     */
    private $biker;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CoursePrice", mappedBy="course", cascade={"persist", "remove"})
     */
    private $coursePrice;

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
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     * @return $this
     */
    public function setClient($client): self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeliverabilityTime(): \DateTimeInterface
    {
        return $this->deliverabilityTime;
    }

    /**
     * @param mixed $deliverabilityTime
     * @return $this
     */
    public function setDeliverabilityTime(\DateTimeInterface $deliverabilityTime): self
    {
        $this->deliverabilityTime = $deliverabilityTime;
        return $this;
    }

    /**
     * @return Biker|null
     */
    public function getBiker(): ?Biker
    {
        return $this->biker;
    }

    /**
     * @param Biker|null $biker
     * @return $this
     */
    public function setBiker(?Biker $biker): self
    {
        $this->biker = $biker;
        return $this;
    }

    /**
     * @return CoursePrice |null
     */
    public function getCoursePrice(): ?CoursePrice
    {
        return $this->coursePrice;
    }

    /**
     * @param CoursePrice |null $coursePrice
     * @return $this
     */
    public function setCoursePrice(?CoursePrice $coursePrice): self
    {
        $this->coursePrice = $coursePrice;
        // set (or unset) the owning side of the relation if necessary
        $newCoursePrice = null === $coursePrice ? null : $this;
        if ($coursePrice->getCoursePrice() !== $newCoursePrice) {
            $coursePrice->setCoursePrice($newCoursePrice);
        }
        return $this;
    }
}
