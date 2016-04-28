<?php
# Copyright (c)  2015 - <mlunzena@uos.de>
#
# Permission is hereby granted, free of charge, to any person obtaining a copy
# of this software and associated documentation files (the "Software"), to deal
# in the Software without restriction, including without limitation the rights
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
# copies of the Software, and to permit persons to whom the Software is
# furnished to do so, subject to the following conditions:
#
# The above copyright notice and this permission notice shall be included in all
# copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
# SOFTWARE.
namespace VHS;

// this class first tries to find a patch template in its patch path
class PatchTemplateFactory extends \Flexi_TemplateFactory
{
    // the original core factory used by Stud.IP
    private $core_factory;

    function __construct(\Flexi_TemplateFactory $core_factory, $patch_path) {
        parent::__construct($patch_path);
        $this->core_factory = $core_factory;
    }

    /**
     * This method behaves as usual but prefers files from the "patch"
     * location over the "core" files of Stud.IP.
     *
     * @param  string     a template string
     *
     * @return string     an absolute filename
     *
     * @throws Flexi_TemplateNotFoundException  if the template could not be found
     */
    function get_template_file($template0) {
        try {
            return parent::get_template_file($template0);
        } catch (\Flexi_TemplateNotFoundException $e) {
            return $this->core_factory->get_template_file($template0);
        }
    }
}

