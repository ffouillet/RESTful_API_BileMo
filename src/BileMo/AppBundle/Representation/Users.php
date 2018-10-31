<?php
namespace BileMo\AppBundle\Representation;

use JMS\Serializer\Annotation\Type;

class Users extends PagineableEntities
{
    /**
     * @Type("array<BileMo\AppBundle\Entity\User>")
     */
    public $data;
}