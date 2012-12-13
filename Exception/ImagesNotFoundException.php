<?php
/*
 * This file is part of NeutronFormBundle
 *
 * (c) Nikolay Georgiev <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\FormBundle\Exception;

class ImagesNotFoundException extends \DomainException implements ExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Images are not found.');
    }
}