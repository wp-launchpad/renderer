<?php

namespace LaunchpadRenderer\Configuration;

class Factory
{
    /**
     * Make a configuration class.
     *
     * @param array $data Data to send to the class.
     *
     * @return Configurations
     */
    public function make(array $data): Configurations {
        return new Configurations($data);
    }
}
