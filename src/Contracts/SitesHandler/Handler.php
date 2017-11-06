<?php

namespace IceTea\Contracts\SitesHandler;

interface Handler
{
    public function __construct();

    public function exec();

    public function parse();

    public function getResult();
}
