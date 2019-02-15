<?php namespace App\Models\Entity;

use Swoft\Db\Model;
use Swoft\Db\Bean\Annotation\Column;
use Swoft\Db\Bean\Annotation\Entity;
use Swoft\Db\Bean\Annotation\Id;
use Swoft\Db\Bean\Annotation\Required;
use Swoft\Db\Bean\Annotation\Table;
use Swoft\Db\Types;


/**
 * @Entity()
 * @Table(name="news")
 * @uses      News
 */
class News extends Model
{
    /**
     * @var int $id
     * @Id()
     * @Column(name="id", type="integer")
     */
    private $id;
    /**
     * @var string $title
     * @Column(name="title", type="string", length=255, default="")
     */
    private $title;

    /**
     * @param int $value
     * @return $this
     */
    public function setId(int $value)
    {
        $this->id = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setTitle(string $value): self
    {
        $this->title = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


}