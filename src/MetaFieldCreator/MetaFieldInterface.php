<?php
/**
 * This software belongs to Dennis Barlowe (Aschaffenburg, Germany) and is copyrighted.
 *
 * Any unauthorized use of this software without having a valid license
 * violates the license agreement and will be prosecuted by the proper authorities.
 *
 * Creator: dbarlowe
 * Date: 18.05.20 - 21:18
 *
 * @link https://www.dennzo.com
 * @copyright 2020 Dennis Barlowe
 */

namespace Dennzo\WordpressHelper\MetaFieldCreator;

interface MetaFieldInterface
{
    /**
     * @return string
     */
    public function getMetaKey(): string ;

    /**
     * @return void
     */
    public function html(): void;
}
