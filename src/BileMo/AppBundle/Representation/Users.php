<?php
namespace BileMo\AppBundle\Representation;

use JMS\Serializer\Annotation\Type;

class MobilePhones extends PagineableEntities
{
    /**
     * @Type("array<BileMo\AppBundle\Entity\Users>")
     */
    public $data;
}