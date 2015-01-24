<?php

class DisplayHook
{
    public function captureOutput()
    {
        $this->CI =& get_instance();
        $output = $this->CI->output->get_output();

        if (ENVIRONMENT != 'testing') {
            echo $output;
        }
    }
}